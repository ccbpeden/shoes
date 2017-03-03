<?php
    Class Store
    {
        private $store_name;
        private $id;

        function __construct($store_name, $id = null)
        {
            $valid = Store::validate($store_name);
            if ($valid)
            {
                $this->setStoreName($store_name);
                $this->setId($id);
            }
        }

        function getStoreName()
        {
            return $this->store_name;
        }

        function setStoreName($store_name)
        {
            $valid = Store::validate($store_name);
            if ($valid)
            {
                $this->store_name = $store_name;
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
            $GLOBALS['DB']->exec("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $all_stores = array();
            foreach($returned_stores as $store)
            {
                $store_name = $store['store_name'];
                $store_id = $store['id'];
                $new_store = new Store($store_name, $store_id);
                $new_store->desanitize();
                array_push($all_stores, $new_store);
            }
            return $all_stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
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
            $this->store_name = htmlspecialchars(addslashes(trim($this->store_name)));
        }

        function desanitize()
        {
            $this->store_name = htmlspecialchars_decode(stripslashes($this->store_name));
        }

        static function findById($id)
        {
            $all_stores = Store::getAll();
            foreach($all_stores as $store)
            {
                $store_id = $store->getId();
                if($store_id == $id)
                {
                    return $store;
                }
            }
        }

        static function findByName($name)
        {
            $all_stores = Store::getAll();
            foreach($all_stores as $store)
            {
                $store_name = $store->getStoreName();
                if($store_name == $name)
                {
                    return $store;
                }
            }
        }

        function update($new_store_name)
        {
            $valid = Store::validate($new_store_name);
            if($valid)
            {
                $this->setStoreName($new_store_name);
                $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_store_name}' WHERE id = {$this->getId()};");
            }
        }
    }
?>
