<?php

include("../helpers/database.php");
include("../env.php");


session_start();
if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
    echo json_encode(["redirect"=>true]);
    exit;
}


$db = new Database(dbUser, dbPass, dbName);
if($db){
    try {
        $orderId = $db->fetchLastRow("order");

        $last_products = $db->join_three_tables(
            "order", "order_product", "product",
            "`order`.`id` = `order_product`.`order_id`",
            "`order_product`.`product_id` = `product`.`id`",
            "`product`.*",
            "`order`.id={$orderId['id']}"
        );
        echo json_encode(["last_products"=>$last_products]);
    }catch (Exception $e){
        echo $e->getMessage();
    }
}