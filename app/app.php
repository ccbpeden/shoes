
<?php
    date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app['debug'] = true;

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app->register(
        new Silex\Provider\TwigServiceProvider(),
        array('twig.path' => __DIR__.'/../views')
    );
    // Book Routes
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array());
    });

    $app->get("/stores", function () use ($app) {
        $all_stores = Store::getAll();
        return $app['twig']->render('stores.html.twig', array('stores'=>$all_stores));
    });

    $app->post("/add_store", function () use ($app) {
        $store_name = $_POST['store_name'];
        $is_valid = Store::validate($store_name);
        if($is_valid){
        $new_store = new Store($store_name);
        $new_store->save();
            return $app->redirect("/stores");
        } else {
            return $app['twig']->render('fail.html.twig');
        }
    });

    $app->get("/store/{id}", function ($id) use ($app){
        $store = Store::findById($id);
        $carried_brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app['twig']->render('store.html.twig', array('store'=>$store,'carried'=>$carried_brands, 'allbrands'=>$all_brands));
    });

    $app->post("/add_brand_to_store", function () use ($app){
        $store = Store::findById($_POST['store_id']);
        $store->addbrand($_POST['brand_id']);
        return $app->redirect("/stores");
    });

    $app->patch("/update_store", function() use ($app){
        $store = Store::findById($_POST['id']);
        $store->update($_POST['store_name']);
        return $app->redirect("/stores");
    });

    $app->delete("/delete_store", function() use ($app){
        $store = Store::findById($_POST['id']);
        $store->delete();
        return $app->redirect("/stores");
    });

    $app->get("/brands", function () use ($app) {
        $all_brands = Brand::getAll();
        return $app['twig']->render('brands.html.twig', array('brands'=>$all_brands));
    });

    $app->post("/addbrand", function () use ($app) {
        $brand_name = $_POST['brand_name'];
        $is_valid = Brand::validate($brand_name);
        if($is_valid){
            $new_brand = new Brand($brand_name);
            $new_brand->save();
            return $app->redirect("/brands");
        } else {
            return $app['twig']->render('fail.html.twig');
        }
    });

    $app->get("/brand/{id}", function ($id) use ($app){
        $brand = Brand::findById($id);
        $carrying_stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app['twig']->render('brand.html.twig', array('brand'=>$brand,'carrying_stores'=>$carrying_stores, 'all_stores'=>$all_stores));
    });


    $app->post("/add_store_to_brand", function () use ($app){
        $brand = Brand::findById($_POST['brand_id']);
        $brand->addStore($_POST['store_id']);
        return $app->redirect("/brands");
    });

    return $app;
?>
