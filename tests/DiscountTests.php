<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 11:41
 */

use PHPUnit\Framework\TestCase;


use App\Discounts\DiscountWorkers\XPctTotalDiscountOnYAlreadyOrdered;
use App\Discounts\DiscountWorkers\XFreeItemsWhenBuyingYFromCatZ;
use App\Discounts\DiscountWorkers\XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory;



class DiscountTests extends TestCase
{
    /**
     * Discount case 1:
     * Customers that have already order for over € 1000 get a 10% discount on every order they make.
     *
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

    /**
     * Discount case 2:
     * For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
     */

    public function testFreeItemsWhenBuying5FromCategory2()
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

        $initialQuantity = $order->items[0]->quantity;

        // First test, should not get free items since numberOfItemsNeeded is greater than quantity ordered
        $discountWorker2 = new XFreeItemsWhenBuyingYFromCatZ("For every product of category \"Switches\" (id 2), when you buy five, you get a sixth for free.",
            1, 11, 2);
        $discountWorker2->calcDiscount($order);


        $this->assertEquals(10, $order->items[0]->quantity);


        // Second test, should not get free items, since ordered items are of wrong category
        $discountWorker2 = new XFreeItemsWhenBuyingYFromCatZ("For every product of category \"Switches\" (id 2), when you buy five, you get a sixth for free.",
            1, 5, 3);
        $discountWorker2->calcDiscount($order);

        $this->assertEquals(10, $order->items[0]->quantity);

        // Third test, should get 4 free items
        $discountWorker2 = new XFreeItemsWhenBuyingYFromCatZ("For every product of category \"Switches\" (id 2), when you buy five, you get a sixth for free.",
            2, 5, 2);
        $discountWorker2->calcDiscount($order);

        $this->assertEquals(14, $order->items[0]->quantity);


        // Fourth test, should get  2 free items

        //Resetting quantity to initial value
        $order->items[0]->quantity = $initialQuantity;

        $discountWorker2 = new XFreeItemsWhenBuyingYFromCatZ("For every product of category \"Switches\" (id 2), when you buy five, you get a sixth for free.",
            1, 5, 2);
        $discountWorker2->calcDiscount($order);

        $this->assertEquals(12, $order->items[0]->quantity);

    }

    /**
     * Discount case 3:
     * If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
     */
    public function test20pctDiscountOnCheapestProductInCategory1WhenBuying2OrMore()
    {
        $order = '{
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
                        }
                      ],
                      "total": "69.00"
                    }';

        $order = json_decode($order);
        $order->totalAfterDiscounts = $order->total;

        $initialPrice = $order->total;

        // First test, should not get a discount since it's all in wrong category
        $discountWorker3 = new XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory("If you buy two or more products of category \"Tools\" (id 1), you get a 20% discount on the cheapest product.",
            20, 2, 2);
        $discountWorker3->calcDiscount($order);

        $this->assertEquals($initialPrice, $order->totalAfterDiscounts);

        // Second test, should not get a discount, too few products

        $discountWorker3 = new XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory("If you buy two or more products of category \"Tools\" (id 1), you get a 20% discount on the cheapest product.",
            20, 4, 1);
        $discountWorker3->calcDiscount($order);

        $this->assertEquals($initialPrice, $order->totalAfterDiscounts);

        // Third test, should get a discount (3.90)
        $discountWorker3 = new XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory("If you buy two or more products of category \"Tools\" (id 1), you get a 20% discount on the cheapest product.",
            20, 2, 1);
        $discountWorker3->calcDiscount($order);

        $this->assertEquals($initialPrice - 3.90, $order->totalAfterDiscounts);


    }

}
