<?php
require_once("inc/autoloader.php");

/* тестовый массив продуктов */
$testProducts = ['A' => 100, 'B' => 900, 'C' => 152,
                 'D' => 400, 'E' => 500, 'F' => 450,
                 'G' => 350, 'H' => 850, 'I' => 630,
                 'J' => 940, 'K' => 715, 'L' => 635,
                 'M' => 770];

/* преобразуем его в обэкт ProductSet */
$testProdSet = new ProductSet();
foreach ($testProducts as $name => $price) {
    $testProdSet->add( new Product($name, $price)); 
}

/* достучаться до продукта можно по имени */
//$product = $testProdSet->getProductByName('A');

//-------------------------------------
/* создаем скидки */
//скидка 1
$productSet = new ProductSet();
$productSet->add($testProdSet->getProductByName('A'));
$productSet->add($testProdSet->getProductByName('B'));

$discount1 = new Discount_ProductSet();
$discount1->setProductSet($productSet);
$discount1->setDiscount(10);

//----------------------------------------------------
//скидка 2
$productSet = new ProductSet();
$productSet->add($testProdSet->getProductByName('D'));
$productSet->add($testProdSet->getProductByName('E'));

$discount2 = new Discount_ProductSet();
$discount2->setProductSet($productSet);
$discount2->setDiscount(5);

//----------------------------------------------------
//скидка 3
$productSet = new ProductSet();
$productSet->add($testProdSet->getProductByName('E'));
$productSet->add($testProdSet->getProductByName('F'));
$productSet->add($testProdSet->getProductByName('G'));

$discount3 = new Discount_ProductSet();
$discount3->setProductSet($productSet);
$discount3->setDiscount(5);

//-----------------------------------------------------
//скидка 4
$productSet = new ProductSet();
$productSet->add($testProdSet->getProductByName('K'));
$productSet->add($testProdSet->getProductByName('L'));
$productSet->add($testProdSet->getProductByName('M'));

$discount4 = new Discount_InProductSet();
$discount4->setProduct($testProdSet->getProductByName('A'));
$discount4->setIsInProductSet($productSet);
$discount4->setDiscount(5);

//скидка 5
$productSet = new ProductSet();
$productSet->add($testProdSet->getProductByName('A'));
$productSet->add($testProdSet->getProductByName('C'));

$discount5 = new Discount_ProductCount();
$discount5->setNonInProductSet($productSet);
$discount5->setCount(3);
$discount5->setDiscount(5);

//-------------------------------------
//скидка 6
$productSet = new ProductSet();
$productSet->add($testProdSet->getProductByName('A'));
$productSet->add($testProdSet->getProductByName('C'));

$discount6 = new Discount_ProductCount();
$discount6->setNonInProductSet($productSet);
$discount6->setCount(4);
$discount6->setDiscount(10);

//--------------------------------------
//скидка 7
$productSet = new ProductSet();
$productSet->add($testProdSet->getProductByName('A'));
$productSet->add($testProdSet->getProductByName('C'));

$discount7 = new Discount_ProductCount();
$discount7->setNonInProductSet($productSet);
$discount7->setCount(5);
$discount7->setDiscount(20);

//--------------------------------------
$testDiscProdSet = new ProductSet();

$testDiscProdSet->add(clone $testProdSet->getProductByName('A'));
$testDiscProdSet->add(clone $testProdSet->getProductByName('A'));
$testDiscProdSet->add(clone $testProdSet->getProductByName('K'));
$testDiscProdSet->add(clone $testProdSet->getProductByName('B'));
$testDiscProdSet->add(clone $testProdSet->getProductByName('K'));
$testDiscProdSet->add(clone $testProdSet->getProductByName('K'));

$discountManager = new Discount_Manager();
$discountManager->add($discount1);
$discountManager->add($discount2);
$discountManager->add($discount3);
$discountManager->add($discount4);
$discountManager->add($discount5);
$discountManager->add($discount6);
$discountManager->add($discount7);

// формируем заказ в корзине

$productOrder = new Order();
$productOrder->push(clone $testProdSet->getProductByName('A'));
$productOrder->push(clone $testProdSet->getProductByName('A'));
$productOrder->push(clone $testProdSet->getProductByName('K'));
$productOrder->push(clone $testProdSet->getProductByName('B'));
$productOrder->push(clone $testProdSet->getProductByName('K'));
$productOrder->push(clone $testProdSet->getProductByName('C'));
$productOrder->push(clone $testProdSet->getProductByName('D'));
$productOrder->push(clone $testProdSet->getProductByName('D'));
$productOrder->push(clone $testProdSet->getProductByName('D'));
$productOrder->push(clone $testProdSet->getProductByName('D'));

$calculator = new Calculator();

$calculator->setOrder($productOrder);
$calculator->setDiscountManager($discountManager);

var_dump($calculator->doCalculation());
