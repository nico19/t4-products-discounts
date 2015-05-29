<?php
    require_once("inc/autoloader.php");
    
    class Discount_Manager{
        public $discounts;
        public function add(Discount $discountProductSet){
            $this->discounts[] = $discountProductSet;
        }
    }
?>