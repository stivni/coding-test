<?php
// to be received via request 
$_POST["order"] = '{
    "id": "1",
    "customer-id": "1",
    "items": [
        {
        "product-id": "B101",
        "quantity": "10",
        "total": "49.9",
        "price": "4.99"
      },
      {
        "product-id": "A101",
        "quantity": "100",
        "total": "975",
        "unit-price": "9.75"
      }
    ],
    "total": "1024.9"
  }';


require_once("calc_discounts.php");
$calculator = new Calc_discounts();
$order = json_decode($_POST["order"]);
$ret = $calculator->calculate($order);
echo $order->total."<br/>";
foreach($ret as $discounts)
{
    echo $discounts."<br/>";
}
array(
    "order" => $order,
    "discounts" => $ret
);





?>
