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
    }
?>
