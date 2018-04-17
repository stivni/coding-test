<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 20:23
 */

namespace App\Discounts;

use App\Discounts\DiscountFactory;
use App\Discounts\DiscountTypes\XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory;

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
// TODO SPLIT FETCHING FUNCTIONALITY TO DIFFERENT CLASS

class DiscountCalculator
{

    public function calcDiscounts(&$order)
    {

        $order->totalAfterDiscounts = $order->total;
        $order->discounts = array();


//        foreach ($this->getAllDiscountWorkers() as $worker) {
//
//            $worker->calcDiscount($order);
//        }

        $this->runDiscountWorkers($order);


    }


    private function runDiscountWorkers(&$order)
    {
        foreach (glob(__DIR__ . '/discountWorkers/*.php') as $file) {
            // get the file name of the current file without the extension
            // which is essentially the class name and construct worker

            $discountWorker = DiscountFactory::factory(basename($file, '.php'));

            $discountWorker->calcDiscount($order);
        }
    }


}