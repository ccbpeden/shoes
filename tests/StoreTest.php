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
            $store_name = "Bob's Discount Shoes & More";
            $new_store = new Store($store_name);
            $new_store->save();
            $result1 = $new_store->getStoreName();

            $stored_store = Store::getAll();
            $result2 = $stored_store[0]->getStoreName();

            $this->assertEquals(["Bob\'s Discount Shoes &amp; More", "Bob's Discount Shoes & More"], [$result1, $result2]);
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

        function test_findByName()
        {
            $store_name1 = "Discount Shoes";
            $store1 = new Store($store_name1);
            $store1->save();
            $store_name2 = "Exquisite Footwear";
            $store2 = new Store($store_name2);
            $store2->save();
            $search_name = $store2->getStoreName();

            $result = Store::findByName($search_name);

            $this->assertEquals($store2, $result);
        }

        function test_update()
        {
            $store_name1 = "Discount Shoes";
            $store1 = new Store($store_name1);
            $store1->save();
            $store_name2 = "Exquisite Footwear";

            $store1->update($store_name2);
            $result = $store1->getStoreName();

            $this->assertEquals($store_name2, $result);
        }

        function test_addBrandGetBrands()
        {
            $store_name1 = "Discount Shoes";
            $store1 = new Store($store_name1);
            $store1->save();
            $brand_name1 = "Guido";
            $brand1 = new Brand($brand_name1);
            $brand1->save();
            $input_brand_id1 = $brand1->getId();
            $brand_name2 = "Abliblas";
            $brand2 = new Brand($brand_name2);
            $brand2->save();
            $brand_name3 = "Mikee";
            $brand3 = new Brand($brand_name3);
            $brand3->save();
            $input_brand_id3 = $brand3->getId();

            $store1->addBrand($input_brand_id1);
            $store1->addBrand($input_brand_id3);
            $result = $store1->getBrands();

            $this->assertEquals([$brand1, $brand3], $result);
        }

        function test_delete()
        {
            $store_name1 = "Discount Shoes";
            $store1 = new Store($store_name1);
            $store1->save();
            $store_name2 = "Exquisite Footwear";
            $store2 = new Store($store_name2);
            $store2->save();


            $store1->delete();
            $result=Store::getAll();

            $this->assertEquals([$store2], $result);
        }

        function test_deleteinjointable()
        {
            $brand_name1 = "Guido";
            $brand1 = new Brand($brand_name1);
            $brand1->save();
            $store_name1 = "Discount Shoes";
            $store1 = new Store($store_name1);
            $store1->save();
            $store_name2 = "Exquisite Footwear";
            $store2 = new Store($store_name2);
            $store2->save();

            $brand1->addStore($store1->getId());
            $brand1->addStore($store2->getId());

            $store1->delete();
            $result=$brand1->getStores();

            $this->assertEquals([$store2], $result);
        }
    }
?>
