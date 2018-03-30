<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 30/03/18
 * Time: 18:20
 */

namespace Tests;

use App\Discounts\DiscountWorkers\XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory;
use PHPUnit\Framework\TestCase;

class XPctDiscountOnCheapestItemOnBuyingYProductsInZCategoryTest extends TestCase
{

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
