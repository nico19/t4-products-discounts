<?php
require_once("inc/autoloader.php");

class Calculator{
    public $order;
    public $discountManager;
    
    public function setOrder(Order $order){
        $this->order =$order;
    }
    
    public function setDiscountManager(Discount_Manager $discountManager){
        $this->discountManager = $discountManager;
    }
    public function doCalculation(){
        foreach ($this->discountManager->discounts as $discount) {
            $discount->getDiscount($this->order->productSet);
        }
        return $this->order;
    }
}

?>