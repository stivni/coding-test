<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 16:54
 */

namespace App\Discounts\DiscountTypes;


use App\Data\ProductRepo;
use App\Model\Discount;

/**
 * Discount case 2:
 * For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
 */
class XFreeItemsWhenBuyingYFromCatZ implements iDiscount
{

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
    function __construct($reason, $numberOfFreeItems, $numberOfItemsNeeded, $validCategory)
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

        $productRepo = ProductRepo::instance();

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

    private function calcNumberOfFreeItems($item)
    {
        return intdiv($item->quantity, $this->getNumberOfItemsNeeded()) * $this->getNumberOfFreeItems();
    }

    private function applyDiscounts(&$order, &$item, $numberOfFreeItemsToAdd)
    {

        $discount = $numberOfFreeItemsToAdd * $item->{"unit-price"};
        $item->quantity += $numberOfFreeItemsToAdd;
        $order->discounts[] = new Discount($this->getReason(), $discount);
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
    private function getNumberOfFreeItems()
    {
        return $this->numberOfFreeItems;
    }


    /**
     * @return mixed
     */
    private function getNumberOfItemsNeeded()
    {
        return $this->numberOfItemsNeeded;
    }


    /**
     * @return mixed
     */
    private function getValidCategory()
    {
        return $this->validCategory;
    }


}