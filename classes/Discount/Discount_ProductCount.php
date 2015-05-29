<?php
require_once("inc/autoloader.php");

class Discount_ProductCount extends Discount{
    public $count;
    public $nonInProductSet;
    public function setCount($count){
        $this->count = $count;
    }
    public function setNonInProductSet(ProductSet $productSet){
        $this->nonInProductSet = $productSet;
    }
    private function countProducts(ProductSet &$productSet){
        $count = 0;
        foreach ($productSet->productSet as $product) {
            if(!in_array($product, $this->nonInProductSet->productSet) && !$product->usedInDiscount)
                $count++;
        }
        return $count;
    }
    
    public function getDiscount(ProductSet &$productSet){
        $productCount = $this->countProducts($productSet);
            if($productCount == $this->count){
                foreach ($productSet->productSet as $product) {
                    if (!in_array($product, $this->nonInProductSet->productSet) && !$product->usedInDiscount){
                        $product->usedInDiscount = true; // отмечаем продукт как участвующий в скидке
                        $product->price = 
                            $product->price -
                                ($product->price *
                                     ($this->discount / 100));
                    }
            }

            return $this->discount;
        }
        return 0;
    }
}