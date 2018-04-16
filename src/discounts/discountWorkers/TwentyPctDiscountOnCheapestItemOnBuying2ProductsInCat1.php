<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 8/04/18
 * Time: 16:01
 */

namespace App\Discounts\DiscountWorkers;

use App\Discounts\DiscountTypes\XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory;

class TwentyPctDiscountOnCheapestItemOnBuying2ProductsInCat1 extends XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory
{


    /**
     * TwentyPctDiscountOnCheapestItemOnBuying2ProductsInCat1 constructor.
     */
    public function __construct()
    {
        parent::__construct("If you buy two or more products of category 'Tools' (id 1), you get a 20% discount on the cheapest product.",
            20, 2, 1);
    }
}