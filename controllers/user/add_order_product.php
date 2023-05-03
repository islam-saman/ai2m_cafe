<?php

include ("../../helpers/database.php");
include ("../../env.php");


$db = new Database(dbUser, dbPass, dbName);
$order_product_data = json_decode($_POST['ordPrd'], true);

if($db){
    if ($order_product_data){
        $order_product = $db->insert("order_product",
            ["order_id","product_id","quantity","sub_total"],
            [
                $order_product_data['order_id'],
                $order_product_data['product_id'],
                $order_product_data['quantity'],
                $order_product_data['sub_total']
            ]
        );
        echo json_encode($order_product);
    }else{
        echo json_encode(array("error" => "Error"));
    }
}