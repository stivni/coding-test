<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 12:05
 */

namespace App\Data;

class CustomerRepo
{
    /**
     * Imagine this is an API call
     */

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

    public function getCustomerById($id)
    {
        $customerJson = file_get_contents(__DIR__ . "/../../data/customers.json");


        $customerArr = json_decode($customerJson);

        foreach ($customerArr as $c) {
            if ($c->id == $id) {
                return $c;
            }
        }
        return false;
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


