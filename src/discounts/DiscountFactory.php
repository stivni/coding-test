<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 16/04/18
 * Time: 06:34
 */

namespace App\Discounts;


class DiscountFactory
{
    public static function factory($type)
    {
        $class = 'App\\Discounts\\DiscountWorkers\\' . $type;
        return new $class();
    }
}