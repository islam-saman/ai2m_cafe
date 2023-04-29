<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../helpers/database.php";
include "../../env.php";
$db = new Database(dbUser, dbPass, dbName);

// Check if the request is for a specific order detail
if(isset($_GET['id'])){
    $orderId = $_GET['id'];
    // Query the database to get the order details for the specified order ID
    try {
        $order = $db->fetchOne("order", "id", "{$orderId}");
        $order_products = $db->join_four_tables(
            "order", "product", "order_product", "category",
            "id", "id", "product_id", "id",
            "order_product.*, product.*"
            ,"order_id = {$orderId}");
        $result = ["order_products" => $order_products];
        echo json_encode($result);
    } catch (Exception $e) {
        var_dump($e);
    }
} else { // If no order ID is provided, return all orders
    try {
        $orders = $db->join_two_tables("order", "user", "user_id", "id","`order`.* , `user`.name , `user`.profile_picture");
        $orders_products = $db->join_three_tables("order", "product", "order_product", "id", "id", "order_id");
        $result = ["orders"=> $orders, "orders_products" => $orders_products];
        echo json_encode($result);
    } catch (Exception $e) {
        var_dump($e);
    }
}
