<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 30/03/18
 * Time: 12:30
 */
require __DIR__ . '/vendor/autoload.php';

use App\Discounts\DiscountCalculator;

$order = '{
              "id": "3",
              "customer-id": "2",
              "items": [
                {
                    "product-id": "A101",
                  "quantity": "2",
                  "unit-price": "9.75",
                  "total": "19.50"
                },
                {
                    "product-id": "A102",
                  "quantity": "1",
                  "unit-price": "49.50",
                  "total": "49.50"
                },
                 {
                        "product-id": "B102",
                        "quantity": "10",
                        "unit-price": "4.99",
                        "total": "49.90"
                        }
              ],
              "total": "69.00"
            }';

$discountCalculator = new DiscountCalculator();
$discountCalculator->calcDiscounts($order);
