<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 17:38
 */

namespace App\Data;

class ProductRepo
{
    /**
     * Imagine this is an API Call
     */

    public function getProductById($id)
    {
        $productJson = file_get_contents(__DIR__ . "/../../data/products.json");

        $productArr = json_decode($productJson);

        foreach ($productArr as $p) {
            if ($p->id == $id) {
                return $p;
            }
        }
        return false;
    }

}