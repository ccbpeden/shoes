
<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Brand.php";
    // require_once "src/Store.php";
    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
        // Brand::deleteAll();
        // Store::deleteAll();
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
    }
?>
