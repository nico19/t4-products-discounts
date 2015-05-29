<?php
require_once("inc/autoloader.php");

class Order{
    public $productSet;
    public function Order(){
        $this->productSet = new ProductSet();
    }
    public function push(Product $product){
        $this->productSet->add($product);
    } 
}
?>