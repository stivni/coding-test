<?php 
class discount_worker_one
{
 
    public function calc(&$order)
    {
        // total products is > 1000 then discount 10%
        if($order->total > 1000)
        {
            $order->total = $order->total * 0.9;
            return "The order total exceeds 1000€. A discount of 10% has been applied";
        }
        return false;
    }
}


?>