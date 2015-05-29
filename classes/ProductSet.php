<?php
require_once("inc/autoloader.php");


class ProductSet{
    public $productSet;
    public function add(Product $product){
        $this->productSet[] = $product;
    }
    
    public function getProductByName($name){
        foreach ($this->productSet as $product) {
            if($product->name == $name){
                return $product;
            }
        }
    }
}
?>