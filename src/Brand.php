<?php
    Class Brand
    {
        private $brand_name;
        private $id;

        function __construct($brand_name, $id = null)
        {
            $valid = Brand::validate($brand_name);
            if ($valid)
            {
                $this->setBrandName($brand_name);
                $this->setId($id);
            }
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        function setBrandName($brand_name)
        {
            $valid = Brand::validate($brand_name);
            if ($valid)
            {
                $this->brand_name = $brand_name;
            }
        }

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        function save()
        {
            $this->sanitize();
            $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $all_brands = array();
            foreach($returned_brands as $brand)
            {
                $brand_name = $brand['brand_name'];
                $brand_id = $brand['id'];
                $new_brand = new Brand($brand_name, $brand_id);
                $new_brand->desanitize();
                array_push($all_brands, $new_brand);
            }
            return $all_brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function validate($input)
        {
            $valid = false;
            if($input)
            {
                $valid = true;
            }
            return $valid;
        }

        function sanitize()
        {
            $this->brand_name = htmlspecialchars(addslashes(trim($this->brand_name)));
        }

        function desanitize()
        {
            $this->brand_name = htmlspecialchars_decode(stripslashes($this->brand_name));
        }

        static function findById($id)
        {
            $all_brands = Brand::getAll();
            foreach($all_brands as $brand)
            {
                $brand_id = $brand->getId();
                if($brand_id == $id)
                {
                    return $brand;
                }
            }
        }

        static function findByName($name)
        {
            $all_brands = Brand::getAll();
            foreach($all_brands as $brand)
            {
                $brand_name = $brand->getBrandName();
                if($brand_name == $name)
                {
                    return $brand;
                }
            }
        }

    }
?>
