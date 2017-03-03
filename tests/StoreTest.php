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
    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
        Brand::deleteAll();
        Store::deleteAll();
        // Brand::deletefromJoinTable();
        }

        function test_StoreSettersGettersAndConstructor()
        {
            $store_name = "Shoebox";
            $id = 1;
            $new_store = new Store($store_name, $id);

            $result = array($new_store->getStoreName(), $new_store->getId());

            $this->assertEquals([$store_name, $id], $result);
        }

        function test_SaveGetAllDeleteAllfunctions()
        {
            $store_name = "Shoebox";
            $id = 1;
            $new_store = new Store($store_name, $id);
            $new_store->save();

            $result = Store::getAll();

            $this->assertEquals([$new_store], $result);
        }

        function test_InputValidator()
        {
            $store_name1 = "Shoebox";
            $store_name2 = "";

            $result1 = Store::validate($store_name1);
            $result2 = Store::validate($store_name2);
            $result = array($result1, $result2);

            $this->assertEquals([true, false], $result);
        }

        function test_SanitizeDesanitize()
        {
            $store_name = "Bob's Discount Shoes & More Emporium";
            $new_store = new Store($store_name);
            $new_store->sanitize();
            $result1 = $new_store->getStoreName();

            $new_store->desanitize();
            $result2 = $new_store->getStoreName();
            $result = array($result1, $result2);

            $this->assertEquals(["Bob\'s Discount Shoes &amp; More Emporium","Bob's Discount Shoes & More Emporium"], $result);
        }

        function test_findById()
        {
            $store_name1 = "Discount Shoes";
            $store1 = new Store($store_name1);
            $store1->save();
            $store_name2 = "Exquisite Footwear";
            $store2 = new Store($store_name2);
            $store2->save();
            $search_id = $store1->getId();

            $result = Store::findById($search_id);

            $this->assertEquals($store1, $result);
        }


    }
?>
