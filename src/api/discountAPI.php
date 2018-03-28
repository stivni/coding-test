<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 12:34
 */

// TODO: Write REST API, setup web server for this. And discountcalculator class.
// TODO better discount message (format)

include_once "../discounts/XPctTotalDiscountOnYAlreadyOrdered.php";
include_once "../discounts/XFreeItemsWhenBuyingYFromCatZ.php";
include_once "../discounts/XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory.php";

$order1 = '{
                        "id": "1",
                        "customer-id": "2",
                        "items": [
                        {
                        "product-id": "B102",
                        "quantity": "10",
                        "unit-price": "4.99",
                        "total": "49.90"
                        }
                        ],
                        "total": "49.90"
                        }';
$order2 = '{
                "id": "3",
              "customer-id": "3",
              "items": [
                {
                    "product-id": "A101",
                  "quantity": "2",
                  "unit-price": "9.75",
                  "total": "19.50"
                },
                {
                    "product-id": "A102",
                  "quantity": "1",
                  "unit-price": "49.50",
                  "total": "49.50"
                },
                 {
                        "product-id": "B102",
                        "quantity": "10",
                        "unit-price": "4.99",
                        "total": "49.90"
                        }
              ],
              "total": "69.00"
            }';


$order = json_decode($order2);
$order->totalAfterDiscounts = $order->total;
$order->discounts = array();

/**
 * Discount case 1:
 * Customers that have already order for over € 1000 get a 10% discount on every order they make.
 */

$discountWorker1 = new XPctTotalDiscountOnYAlreadyOrdered("10% total discount on order, for already buying for over €1000.",
    1000, 10);

$discountWorker1->calcDiscount($order);


/**
 * Discount case 2:
 * For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
 */

$discountWorker2 = new XFreeItemsWhenBuyingYFromCatZ("For every product of category \"Switches\" (id 2), when you buy five, you get a sixth for free.",
    1, 5, 2);
$discountWorker2->calcDiscount($order);


/**
 * Discount case 3:
 * If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
 */

$discountWorker3 = new XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory("If you buy two or more products of category \"Tools\" (id 1), you get a 20% discount on the cheapest product.",
    20, 2, 1);
$discountWorker3->calcDiscount($order);

/**
 *Testing the old fashioned way, unsure how to fix phpunit issues
 */

//foreach ($order as $prop => $value) {
//    print("\n" . $prop . ":" . $value);
//}
//echo "\n" . $order->totalAfterDiscounts;
//foreach ($order->items as $i) {
//    print("\n" . "Quantity: " . $i->quantity . " ,Total:" . $i->total . " ,Unit-price" . $i->{"unit-price"});
//}
//
//foreach ($order->discounts as $d) {
//    print("\n" . "Reason: " . $d->reason . " ,Discount:" . $d->discount);
//}





