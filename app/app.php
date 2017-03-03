
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

    $app->post("/addstore", function () use ($app) {
        $store_name = $_POST['store_name'];
        $new_store = new Store($store_name);
        $success = $new_store->save();
        return $app->redirect("/stores");
    });

    $app->get("/brands", function () use ($app) {
        $all_brands = Brand::getAll();
        return $app['twig']->render('brands.html.twig', array('brands'=>$all_brands));
    });

    $app->post("/addbrand", function () use ($app) {
        $brand_name = $_POST['brand_name'];
        $new_brand = new Brand($brand_name);
        $success = $new_brand->save();
        return $app->redirect("/brands");
    });


    return $app;
?>
