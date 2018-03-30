<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 12:01
 */


namespace App\Discounts\DiscountWorkers;

use App\Data\CustomerRepo;
use App\Model\Discount;
/**
 * Discount case 1:
 * Customers that have already ordered for over € X get a Y% discount on every order they make.
 */
class XPctTotalDiscountOnYAlreadyOrdered
{
    private $reason;
    private $totalOrderedRequirement;
    private $pctDiscount;

    /**
     * XPctTotalDiscountOnYAlreadyOrdered constructor.
     */
    public function __construct($reason, $totalOrderedRequirement, $pctDiscount)
    {
        $this->reason = $reason;
        $this->totalOrderedRequirement = $totalOrderedRequirement;
        $this->pctDiscount = $pctDiscount;
    }

    public function calcDiscount(&$order)
    {
        /**
         * Calculates eligibility for discount and then calculates it, returning a string that can be converted to json
         *
         */
        if ($this->isValid($order)) {
            $discount = round($order->totalAfterDiscounts * ($this->getPctDiscount() / 100), 2);
            $order->totalAfterDiscounts -= $discount;
            $order->totalAfterDiscounts;
            $order->discounts[] = new Discount($this->getReason(), $discount);
        }

    }

    public function isValid($order)
    {
        /**
         * Checks if customer is eligible for discount, revenue must be >= totalOrderedRequirement
         */

        $customerRepo = CustomerRepo::instance();

        return $customerRepo->getCustomerById($order->{"customer-id"})->revenue >= $this->getTotalOrderedRequirement() ? true : false;
    }


    /**
     * @return mixed
     */
    private function getReason()
    {
        return $this->reason;
    }


    /**
     * @return mixed
     */
    private function getTotalOrderedRequirement()
    {
        return $this->totalOrderedRequirement;
    }


    /**
     * @return mixed
     */
    private function getPctDiscount()
    {
        return $this->pctDiscount;
    }


}