<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 12:34
 */

// TODO: Write REST API, setup web server for this. And discountcalculator class.

include_once "../discounts/XPctTotalDiscountOnYAlreadyOrdered.php";

$order = '{
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

$order = json_decode($order);
$order->totalAfterDiscounts = $order->total;
$order->discounts = array();

/**
 * Discount case 1:
 * Customers that have already order for over € 1000 get a 10% discount on every order they make.
 */

$discountWorker1 = new XPctTotalDiscountOnYAlreadyOrdered("10% total discount on order, for already buying for over €1000.", 1000, 10);

$discountWorker1->calcDiscount($order);




/**
 *Testing the old fashioned way, unsure how to fix phpunit issues
 */

//foreach($order as $prop=>$value){
//    print("\n".$prop.":".$value);
//}
//echo $order->totalAfterDiscounts."\n";
//foreach ($order->discounts as $d){
//    print("Reason: ".$d->reason."\nDiscount:".$d->discount);
//}





