<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 18:47
 */

namespace App\Discounts\DiscountWorkers;

use App\Data\ProductRepo;
use App\Model\Discount;
/**
 * Discount case 3:
 * If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
 */
class XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory implements iDiscount
{
    private $reason;
    private $pctDiscount;
    private $numberOfProductsNeeded;
    private $validCategory;

    /**
     * XPctDiscountOnCheapestItemOnBuyingYProductsInZCategory constructor.
     * @param $reason
     * @param $pctDiscount
     * @param $numberOfProductsNeeded
     * @param $validCategory
     */
    public function __construct($reason, $pctDiscount, $numberOfProductsNeeded, $validCategory)
    {
        $this->reason = $reason;
        $this->pctDiscount = $pctDiscount;
        $this->numberOfProductsNeeded = $numberOfProductsNeeded;
        $this->validCategory = $validCategory;
    }


    public function calcDiscount(&$order)
    {
        $amountOfProductsInCategory = 0;
        $cheapestItem = null;

        $productRepo = ProductRepo::instance();

        foreach ($order->items as &$item) {
            $product = $productRepo->getProductById($item->{"product-id"});

            if ($product->category == $this->getValidCategory()) {
                $amountOfProductsInCategory += 1;

                if ($cheapestItem == null || $cheapestItem->total > $item->total) {
                    $cheapestItem = &$item;
                }

            }

        }
        if ($amountOfProductsInCategory >= $this->getNumberOfProductsNeeded()) {
            $discount = round($cheapestItem->total * ($this->getPctDiscount() / 100), 2);
            $order->totalAfterDiscounts -= $discount;
            $order->discounts[] = new Discount($this->getReason(), $discount);
        }

    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }


    /**
     * @return mixed
     */
    public function getPctDiscount()
    {
        return $this->pctDiscount;
    }


    /**
     * @return mixed
     */
    public function getNumberOfProductsNeeded()
    {
        return $this->numberOfProductsNeeded;
    }


    /**
     * @return mixed
     */
    public function getValidCategory()
    {
        return $this->validCategory;
    }



}