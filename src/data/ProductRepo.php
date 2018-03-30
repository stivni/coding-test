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

    /**
     * Call this method to get singleton
     */
    public static function instance()
    {
        static $instance = false;
        if ($instance === false) {
            // Late static binding (PHP 5.3+)
            $instance = new static();
        }

        return $instance;
    }


    /**
     * Make constructor private, so nobody can call "new Class".
     */
    private function __construct()
    {
    }

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone()
    {
    }

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep()
    {
    }

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup()
    {
    }


}