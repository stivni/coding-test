<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 30/03/18
 * Time: 18:18
 */

namespace Tests;

use App\Discounts\DiscountWorkers\XPctTotalDiscountOnYAlreadyOrdered;
use PHPUnit\Framework\TestCase;

class XPctTotalDiscountOnYAlreadyOrderedTest extends TestCase
{

    //FIXME

    /**
     * Discount case 1:
     * Customers that have already order for over € 1000 get a 10% discount on every order they make.
     */
    public function test10pctDiscountOn1000AlreadyOrdered()
    {
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


        // First test, should not get a discount since totalOrdered < Requirement
        $totalOrderedRequirement = 2000;
        $percentDiscount = 10;
        $discount10pctCustomerAlreadyBought1K = new     XPctTotalDiscountOnYAlreadyOrdered("10% Total discount on order, for already buying for over €1000."
            , $totalOrderedRequirement, $percentDiscount);


        //Test should be false
        $this->assertEquals(false, $discount10pctCustomerAlreadyBought1K->isValid($order));


        // Second test, should get a discount
        $totalOrderedRequirement = 1000;
        $percentDiscount = 10;
        $discount10pctCustomerAlreadyBought1K = new XPctTotalDiscountOnYAlreadyOrdered("10% Total discount on order, for already buying for over €200."
            , $totalOrderedRequirement, $percentDiscount);

        //Test should be true
        $this->assertEquals(true, $discount10pctCustomerAlreadyBought1K->isValid($order));
        // 10% Discount on 49.90 should be 44.91
        $discount10pctCustomerAlreadyBought1K->calcDiscount($order);
        $this->assertEquals("44.91", $order->totalAfterDiscounts);
    }

}
