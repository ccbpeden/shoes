
<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Brand.php";
    require_once "src/Store.php";
    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
        Brand::deleteAll();
        Store::deleteAll();
        // Brand::deletefromJoinTable();
        }

        function test_BrandSettersGettersAndConstructor()
        {
            $brand_name = "Guido";
            $id = 1;
            $new_brand = new Brand($brand_name, $id);

            $result = array($new_brand->getBrandName(), $new_brand->getId());

            $this->assertEquals([$brand_name, $id], $result);
        }

        function test_SaveGetAllDeleteAllfunctions()
        {
            $brand_name = "Guido";
            $id = 1;
            $new_brand = new Brand($brand_name, $id);
            $new_brand->save();

            $result = Brand::getAll();

            $this->assertEquals([$new_brand], $result);
        }

        function test_InputValidator()
        {
            $brand_name1 = "Guido";
            $brand_name2 = "";

            $result1 = Brand::validate($brand_name1);
            $result2 = Brand::validate($brand_name2);
            $result = array($result1, $result2);

            $this->assertEquals([true, false], $result);
        }

        function test_SanitizeDesanitize()
        {
            $brand_name = "G&ido'$";
            $new_brand = new Brand($brand_name);
            $new_brand->save();
            $result1 = $new_brand->getBrandName();

            $stored_brand = Brand::getAll();
            $result2 = $stored_brand[0]->getBrandName();

            $this->assertEquals(["G&ido'$", "G&amp;ido\'$"], [$result2, $result1]);
        }

        function test_findById()
        {
            $brand_name1 = "Guido";
            $brand1 = new Brand($brand_name1);
            $brand1->save();
            $brand_name2 = "Abliblas";
            $brand2 = new Brand($brand_name2);
            $brand2->save();
            $search_id = $brand1->getId();

            $result = Brand::findById($search_id);

            $this->assertEquals($brand1, $result);
        }

        function test_findByName()
        {
            $brand_name1 = "Guido";
            $brand1 = new Brand($brand_name1);
            $brand1->save();
            $brand_name2 = "Abliblas";
            $brand2 = new Brand($brand_name2);
            $brand2->save();
            $search_name = $brand2->getBrandName();

            $result = Brand::findByName($search_name);

            $this->assertEquals($brand2, $result);
        }

        function test_addStoreGetStores()
        {
            $brand_name1 = "Guido";
            $brand1 = new Brand($brand_name1);
            $brand1->save();
            $store_name1 = "Discount Shoes";
            $store1 = new Store($store_name1);
            $store1->save();
            $store1_id = $store1->getId();
            $store_name2 = "Exquisite Footwear";
            $store2 = new Store($store_name2);
            $store2->save();
            $store_name3 = "Arreeyaie";
            $store3 = new Store($store_name3);
            $store3->save();
            $store3_id = $store3->getId();

            $brand1->addStore($store1_id);
            $brand1->addStore($store3_id);
            $result = $brand1->getStores();

            $this->assertEquals([$store1, $store3], $result);
        }
    }
?>
