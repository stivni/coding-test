<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 12:01
 */

require "../data/CustomerRepo.php";
require "Discount.php";

//TODO refactor
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
        $this->setReason($reason);
        $this->setTotalOrderedRequirement($totalOrderedRequirement);
        $this->setPctDiscount($pctDiscount);
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
            $order->discounts[] = new Discount($this->reason, $discount);
        }

    }

    public function isValid($order)
    {
        /**
         * Checks if customer is eligible for discount, revenue must be >= totalOrderedRequirement
         */

        $customerRepo = new CustomerRepo();

        return $customerRepo->getCustomerById($order->id)->revenue >= $this->getTotalOrderedRequirement() ? true : false;
    }

    public function toString()
    {
        /**
         * Returns discount reason in format that can be converted to json
         */
        return $this->getReason();


    }


    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     * @return XPctTotalDiscountOnYAlreadyOrdered
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalOrderedRequirement()
    {
        return $this->totalOrderedRequirement;
    }

    /**
     * @param mixed $totalOrderedRequirement
     * @return XPctTotalDiscountOnYAlreadyOrdered
     */
    public function setTotalOrderedRequirement($totalOrderedRequirement)
    {
        $this->totalOrderedRequirement = $totalOrderedRequirement;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPctDiscount()
    {
        return $this->pctDiscount;
    }

    /**
     * @param mixed $pctDiscount
     * @return XPctTotalDiscountOnYAlreadyOrdered
     */
    public function setPctDiscount($pctDiscount)
    {
        $this->pctDiscount = $pctDiscount;
        return $this;
    }


}