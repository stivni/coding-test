<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 31/03/18
 * Time: 16:24
 */

namespace App\discounts\discountTypes;


interface IDiscount
{
    public function calcDiscount(&$order);
}