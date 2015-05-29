<?php
require_once("inc/autoloader.php");

/*
* скидки типа продукт и один из множенства
*/
class Discount_InProductSet extends Discount{
    public $product;
    public $isInProductSet;

    public function setProduct(Product $product){
        $this->product = $product;
    }
    public function setIsInProductSet(ProductSet $productSet){
        $this->isInProductSet = $productSet;
    }
    public function getDiscount(ProductSet &$productSet){
        $match = false;
       
        foreach ($productSet->productSet as $inSetProduct) {
            if($this->product == $inSetProduct && !$inSetProduct->usedInDiscount){
                $match = true;
                break;
            }
        }
        $matchInSet = false;
 		//если первый продукт совпадает то ещем в множенстве isInProductSet - один из продуктов
        if($match){
        	foreach ($this->isInProductSet->productSet as $isInProductSet) {
	        	foreach ($productSet->productSet as $checkedProduct) {
	        		if($isInProductSet == $checkedProduct && !$checkedProduct->usedInDiscount){
	        			$matchInSet = true;
	        		}
	        	}
        	}

        }

       //если есть оба совпадения
        if($match && $matchInSet){
        	$usedDiscountForMainProduct = false;
            foreach ($productSet->productSet as $checkedProduct) {
                for ($i = 0; $i < count($this->isInProductSet->productSet); $i++) {
                	if ($checkedProduct == $this->isInProductSet->productSet[$i] && !$checkedProduct->usedInDiscount){
                        $checkedProduct->usedInDiscount = true; // отмечаем продукт как участвующий в скидке
                        $checkedProduct->price = 
                        	$checkedProduct->price -
                        		($checkedProduct->price *
                        			 ($this->discount / 100));
                        break;
                    }
                    if ($this->product == $checkedProduct &&
                         		!$checkedProduct->usedInDiscount &&
                         			!$usedDiscountForMainProduct ){

                        	$checkedProduct->usedInDiscount = true; // отмечаем продукт как участвующий в скидке
                        	$checkedProduct->price = 
                        		$checkedProduct->price -
                        			($checkedProduct->price *
                        				($this->discount / 100));
                        	$usedDiscountForMainProduct = true;
                        }
                }
            }
            return $this->discount;
        }
        return 0;
    }
}