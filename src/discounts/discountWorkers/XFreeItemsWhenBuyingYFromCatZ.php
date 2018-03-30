<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 16:54
 */

namespace App\Discounts\DiscountWorkers;


use App\Data\ProductRepo;
use App\Model\Discount;

//TODO REFACTOR

class XFreeItemsWhenBuyingYFromCatZ
{
    /**
     * Discount case 2:
     * For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
     */

    private $reason;
    private $numberOfFreeItems;
    private $numberOfItemsNeeded;
    private $validCategory;


    /**
     * XFreeItemsWhenBuyingYFromCatZ constructor.
     * @param $reason
     * @param $numberOfFreeItems
     * @param $numberOfItemsNeeded
     * @param $validCategory
     */
    public function __construct($reason, $numberOfFreeItems, $numberOfItemsNeeded, $validCategory)
    {
        $this->reason = $reason;
        $this->numberOfFreeItems = $numberOfFreeItems;
        $this->numberOfItemsNeeded = $numberOfItemsNeeded;
        $this->validCategory = $validCategory;
    }


    public function calcDiscount(&$order)
    {

        /**
         *  Imaginary API call; checks every item in order for eligibility, then calculates number of free items to be added.
         *  Applies discounts
         */

        $productRepo = new ProductRepo();

        foreach ($order->items as &$item) {
            $product = $productRepo->getProductById($item->{"product-id"});

            if ($product->category == $this->getValidCategory() && $item->quantity >= $this->getNumberOfItemsNeeded()) {
                $numberOfFreeItemsToAdd = $this->calcNumberOfFreeItems($item);

                if ($numberOfFreeItemsToAdd > 0) {
                    $this->applyDiscounts($order, $item, $numberOfFreeItemsToAdd);
                }
            }

        }
    }

    function calcNumberOfFreeItems($item)
    {
        return intdiv($item->quantity, $this->getNumberOfItemsNeeded()) * $this->getNumberOfFreeItems();
    }

    function applyDiscounts(&$order, &$item, $numberOfFreeItemsToAdd)
    {

        $discount = $numberOfFreeItemsToAdd * $item->{"unit-price"};
        $item->quantity += $numberOfFreeItemsToAdd;
        $order->discounts[] = new Discount($this->getReason(), $discount);
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
     * @return XFreeItemsWhenBuyingYFromCatZ
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberOfFreeItems()
    {
        return $this->numberOfFreeItems;
    }

    /**
     * @param mixed $numberOfFreeItems
     * @return XFreeItemsWhenBuyingYFromCatZ
     */
    public function setNumberOfFreeItems($numberOfFreeItems)
    {
        $this->numberOfFreeItems = $numberOfFreeItems;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberOfItemsNeeded()
    {
        return $this->numberOfItemsNeeded;
    }

    /**
     * @param mixed $numberOfItemsNeeded
     * @return XFreeItemsWhenBuyingYFromCatZ
     */
    public function setNumberOfItemsNeeded($numberOfItemsNeeded)
    {
        $this->numberOfItemsNeeded = $numberOfItemsNeeded;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidCategory()
    {
        return $this->validCategory;
    }

    /**
     * @param mixed $validCategory
     * @return XFreeItemsWhenBuyingYFromCatZ
     */
    public function setValidCategory($validCategory)
    {
        $this->validCategory = $validCategory;
        return $this;
    }


}