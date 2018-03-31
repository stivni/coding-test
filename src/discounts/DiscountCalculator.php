<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 20:23
 */

namespace App\Discounts;

use App\Discounts\DiscountWorkers\XPctTotalDiscountOnYAlreadyOrdered;
use App\Discounts\DiscountWorkers\XFreeItemsWhenBuyingYFromCatZ;
use App\Discounts\DiscountWorkers\XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory;

class DiscountCalculator
{
    public function calcDiscounts($order)
    {


        $order->totalAfterDiscounts = $order->total;
        $order->discounts = array();


        foreach ($this->getAllDiscountWorkers() as $worker) {

            $worker->calcDiscount($order);
        }

        return $order;

    }

    /**
     * Discount case 1:
     * Customers that have already order for over € 1000 get a 10% discount on every order they make.
     */
    /**
     * Discount case 2:
     * For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
     */
    /**
     * Discount case 3:
     * If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
     *
     * Any new discounts need to be appended to the array
     */

    private function getAllDiscountWorkers()
    {
        return [
            new XPctTotalDiscountOnYAlreadyOrdered("10% total discount on order, for already buying for over €1000.",
                1000, 10),
            new XFreeItemsWhenBuyingYFromCatZ("For every product of category \"Switches\" (id 2), when you buy five, you get a sixth for free.",
                1, 5, 2),
            new XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory("If you buy two or more products of category \"Tools\" (id 1), you get a 20% discount on the cheapest product.",
                20, 2, 1)
        ];
    }


}