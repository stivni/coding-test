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


    /**
     * DiscountCalculator constructor.
     */
    public function __construct()
    {
    }

    public function calcDiscounts($order)
    {


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

        return $order;



    }


}