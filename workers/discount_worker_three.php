<?php 
class discount_worker_three 
{
    public function calc(&$order)
    {
        $items = array();
        $calc_discounts = new Calc_discounts();
        $discounts_applied = "";
        foreach($order->items as $i)
        {
            $attr = "product-id";
            $id = $i->$attr;
            $product = $calc_discounts->getProduts($id);
            $i->description = $product->description;
            $items[$product->category][] = $i;

        }
         // if there's products in category 1 and there's more then 1 then there's a 20% discount on the cheapest
         if(isset($items[1]) &&
         sizeof($items[1]) > 1)
        {
         usort($items[1], function($a, $b) 
             {

                 if($a->total == $b->total)
                 {
                     return 0;                        
                 }
                 return $a->total < $b->total ? -1 : 1;
             }
         );
         $order->total -= $items[1][0]->total *0.2;
         $discounts_applied .= "A 20% discount was applied on {$items[1][0]->description} <br/>";
        }
        return empty($discounts_applied) ? false : $discounts_applied;
    }
}

?>