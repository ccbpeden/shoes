<?php
    Class Brand
    {
        private $brand_name;
        private $id;

        function __construct($brand_name, $id = null)
        {
            $this->setBrandName($brand_name);
            $this->setId($id);
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        function setBrandName($brand_name)
        {
            $this->brand_name = $brand_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

    }
?>
