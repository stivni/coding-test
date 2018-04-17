<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 8/04/18
 * Time: 15:47
 */

namespace App\Discounts\DiscountWorkers;

use App\Discounts\DiscountTypes\XFreeItemsWhenBuyingYFromCatZ;


class FreeItemWhenBuying5FromCat2 extends XFreeItemsWhenBuyingYFromCatZ
{

    /**
     * FreeItemWhenBuying5FromCat2 constructor.
     */
    public function __construct()
    {
        parent::__construct("For every product of category 'Switches' (id 2), when you buy five, you get a sixth for free.",
            1, 5, 2);
    }

}