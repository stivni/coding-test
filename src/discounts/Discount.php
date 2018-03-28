<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 14:41
 */

class Discount
{
    public $reason;
    public $discount;

    /**
     * Discount constructor.
     */
    public function __construct($reason, $discount)
    {
        $this->reason = $reason;
        $this->discount = $discount;
    }


}