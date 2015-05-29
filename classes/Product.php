<?php
class Product{
    public $name;
    public $price;
    public $usedInDiscount = false;
    
    public function Product($name, $price){
        $this->name = $name;
        $this->price = $price;
    }
}