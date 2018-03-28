<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 28/03/18
 * Time: 12:05
 */

class CustomerRepo
{
    public function getCustomerById($id)
    {
        $customerJson = file_get_contents("../../data/customers.json");

        $customerArr = json_decode($customerJson);

        foreach ($customerArr as $c) {
            if ($c->id == $id) {
                return $c;
            }
        }
        return false;
    }

}