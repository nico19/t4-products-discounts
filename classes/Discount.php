<?php
require_once("inc/autoloader.php");

abstract class Discount{
    public $discount;
        
    public function setDiscount($discount){
        $this->discount = $discount;
    }
    
    abstract public function getDiscount(ProductSet &$products);
}
?>