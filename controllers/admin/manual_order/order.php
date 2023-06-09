<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include "../../../helpers/database.php";
include "../../../env.php";
include "../../../helpers/auth.php";

session_start();
if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
    echo json_encode(["redirect"=>true]);
    exit;
}

$user_id = $_SESSION['id'];
$db = new Database(dbUser, dbPass, dbName);
//// Check if user is an admin
$is_admin = check_admin($db, 'user', 'id', $user_id);

if(!$is_admin){
    echo json_encode(["is_admin"=>false]);
    exit;
}
// Check if the request is for a specific order detail
if(isset($_GET['id'])){

    $orderId = $_GET['id'];
    // Query the database to get the order details for the specified order ID
    try {
        $updated = $db->updateById("order",["status"],["out for delivery"],"$orderId");
        echo json_encode($updated);
    } catch (Exception $e) {
        var_dump($e);
    }
} else { // If no order ID is provided, return all orders
    try {
        $orders = $db->join_two_tables("order", "user", "user_id", "id","`order`.*, `user`.name, `user`.profile_picture", "`order`.status='processing'");
        $order_products = $db->join_three_tables(
            "order", "order_product", "product",
            "`order`.`id` = `order_product`.`order_id`",
            "`order_product`.`product_id` = `product`.`id`",
            "`order_product`.*, `product`.*",
            "`order`.status='processing'"
        );


        $result = ["orders"=> $orders, "orders_products" => $order_products];
        echo json_encode($result);
    } catch (Exception $e) {
        var_dump($e);
    }
}
