# **Shoe Store Manager**
#### Charles Peden, 3/3/2017

&nbsp;
## Description
A program that allows a hypothetical shoe store chain magnate to keep track of relationships between various stores and the brands of shoes sold therein.

&nbsp;
## Specifications

|Behavior|Input|Output|Justification|
|--------|-----|------|-------|
| Program successfully instantiates Class Objects, getters work correctly | $new_brand->getBrandName() | "Guido" | A property must be part of a successfully instantiated object to be gotten by a getter.
| program successfully saves object data to sql database | $new_brand->save(); $id = $new_brand->getId(); |  $id = 142 | because an id is not provided locally, any actual id number is provided by the database, proving that the object has been successfully saved.
| Program is able to delete brands collectively |Brand::deleteAll(); $result = Brand::getAll(); | $result = [] | Assuming previous code, if the deleteAll() method weren't working, a getAll() would return the previously created brand.
| Program successfully validates Input | Brand::validate(null); Brand::validate("cake"); | false, true | because default validation state set to false, validation will only set to true if conditions passed.
| Program validates input before instantiating | $new_brand = new Brand(""); $new_brand->getBrandName() | error | unable to instantiate because invalid input |
| program successfully sanitizes input before saving to DB | "G&ido'$" | "G&amp;ido\'$" | input contains both irregular characters and quotes |
| program successfully desanitizes text upon extraction from DB |  "G&amp;ido\'$" | "G&ido'$" | input contains both irregular characters and quotes |
| Program able to find singular instances of class objects by id | instantiate 2 brands, $result = Brand::findById($brand1->getId()) | $result = $brand1 | searching for first brand ensures that return brand isn't merely returning the last brand on list |
| Program able to find singular instances of class objects by name | instantiate 2 brands, $result = Brand::findByName($brand2->getId()) | $result = $brand2 | searching for 2nd brand ensures that return brand isn't merely returning last brand on list |
| Program able to update store information | $new_name = "Exquisite Footwear"; $store->update($new_name); | $result = $store->getStoreName(), $result = "exquisite Footwear"|
| Program successfully creates relationships between brands and stores in join table | 3 brands, 1 store $this->addBrand($brand1_id) $this->addBrand($brand3_id), $result = $this->getBrands() | [$brand1, $brand3] | first and 3rd brands to ensure that not all brands are getting autopushed to brands_stores |
| Program able to find and display all brands of shoes in a particular store |
| Program able to find and display all stores where a brand of shoes is carried |
| Program is able to delete stores and brands individually and |
| Program successfully deletes store-brand relationships from join table when a store is deleted|


## MYSQL commands to replicate Production DB:
CREATE DATABASE shoes;
USE shoes;
CREATE TABLE brands (brand_name VARCHAR (255), id serial PRIMARY KEY);
CREATE TABLE stores (store_name VARCHAR (255),  id serial PRIMARY KEY);
CREATE TABLE brands_stores (brand_id INT, store_id INT, id serial PRIMARY KEY);

&nbsp;
## Setup/Installation Requirements
##### _To view and use this application:_
* You will need the dependency manager Composer installed on your computer to use this application. Go to [getcomposer.org] (https://getcomposer.org/) to download Composer for free.
* Install and configure Mamp, MySQL, and PDO.
* Go to my [Github repository] (https://github.com/ccbpeden/shoes.git)
* Download the zip file via the green button
* Unzip the file and open the **_shoes-master_** folder
* Open Terminal, navigate to **_shoes-master_** project folder, type **_composer install_** and hit enter
* Navigate Terminal to the **_shoes/web_** folder and set up a server by typing **_php -S localhost:8000_**
* Activate Mamp and Start Servers
* In a web browser, browse to localhost:8888/phpmyadmin.
* Click the import tab in the phpmyadmin gui and select the zipped database included in the project folder.
* The application should now load and be ready to use!
* Type **_localhost:8888_** into your web browser

&nbsp;
## Known Bugs
* No known bugs

&nbsp;
## Technologies Used
* PHP
* Silex
* Twig
* Composer
* Bootstrap
* CSS
* HTML

&nbsp;
_If you have any questions or comments about this program, you can contact me at [ccbpeden@warpmail.net](mailto:ccbpeden@warpmail.net)._

Copyright (c) 2017 Charles Peden

This software is licensed under the MIT license
