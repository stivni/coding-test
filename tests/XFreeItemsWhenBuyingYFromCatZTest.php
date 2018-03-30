<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 30/03/18
 * Time: 18:17
 */

namespace Tests;

use App\Discounts\DiscountWorkers\XFreeItemsWhenBuyingYFromCatZ;
use PHPUnit\Framework\TestCase;

class XFreeItemsWhenBuyingYFromCatZTest extends TestCase
{
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


}
