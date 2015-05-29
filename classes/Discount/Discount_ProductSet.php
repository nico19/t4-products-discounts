<?php
require_once("inc/autoloader.php");

class Discount_ProductSet extends Discount{
    public $requiredSet;
    
    public function setProductSet(ProductSet $productSet){
        $this->requiredSet = $productSet;
    }
    
    public function getDiscount(ProductSet &$productSet){
        $matches = 0;
        
        foreach ($this->requiredSet->productSet as $checkedProduct) {
            foreach ($productSet->productSet as $inSetProduct) {
                if($checkedProduct == $inSetProduct && !$inSetProduct->usedInDiscount){
                    $matches++;
                    break;
                }
            }
        }
               
        //если число совпадений равно количеству всех товаров в списке то скидку можно применять
        if($matches == count($this->requiredSet->productSet)){
            foreach ($this->requiredSet->productSet as $checkedProduct) {
                for($i = 0; $i < count($productSet->productSet); $i++) {
                    if($checkedProduct == $productSet->productSet[$i] && !$productSet->productSet[$i]->usedInDiscount){
                        $productSet->productSet[$i]->usedInDiscount = true;
                        $productSet->productSet[$i]->price =  $productSet->productSet[$i]->price - $productSet->productSet[$i]->price * ($this->discount / 100);
                        break;
                    }
                }
            }
            $this->getDiscount($productSet);
        }
        return 0;
    }
}