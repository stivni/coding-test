<?php 

class Calc_discounts
{
    public function __construct()
    {

    }

    public function getProduts($id)
    {
        $products = file_get_contents("./data/products.json");
        $products = json_decode($products);
        foreach($products as $p)
        {
            $attr= "product-id";
            if($p->id == $id)
                return $p;
        }
        return null;
    }

    public function getClient($id)
    {
        $clients = file_get_contents("./data/customers.json");
        $clients = json_decode($clients);
        foreach($clients as $c)
        {
            if($c["id"] == $id)
                return $c;
        }
        return null;
    }

    public function calculate(&$order)
    {
        $files = scandir("./workers");
        $discounts_applied = array();
        
        foreach($files as $f)
        {
            $pos = strpos($f, ".php");

            if($pos === false)
            {
                continue;
            }
            $file_name = substr($f, 0, $pos);
            require_once "./workers/$f";
            $obj = new $file_name();
            $ret = $obj->calc($order);
            if($ret !== false)
            {
                $discounts_applied[] = $ret;
            }
        }
        return $discounts_applied;
        
    }
}




?>