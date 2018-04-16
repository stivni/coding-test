<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 8/04/18
 * Time: 15:54
 */

namespace App\Discounts\DiscountWorkers;

use App\Discounts\DiscountTypes\XPctTotalDiscountOnYAlreadyOrdered;


class TenPctTotalDiscountOnYAlreadyOrdered extends XPctTotalDiscountOnYAlreadyOrdered
{


    /**
     * TenPctTotalDiscountOnYAlreadyOrdered constructor.
     */
    public function __construct()
    {

        parent::__construct("10% total discount on order, for already buying for over €1000.",
            1000, 10);
    }
}