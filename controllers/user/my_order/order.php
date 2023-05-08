<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../helpers/database.php";
include "../../../env.php";
session_start();
if(!isset($_SESSION['is_login'])){

    echo json_encode(["is_login"=>false]);
    exit;
}

if(empty($_GET["userId"]))
    $user_id = $_SESSION['id'];

else
    $user_id = $_GET["userId"];


//exit;
$db = new Database(dbUser, dbPass, dbName);

// Check if the request is for a specific order detail
if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Query the database to get the order details for the specified order ID
    try {

        $order_products = $db->join_three_tables(
            "order", "order_product", "product",
            "`order`.`id` = `order_product`.`order_id`",
            "`order_product`.`product_id` = `product`.`id`",
            "`order_product`.*, `product`.*",
            "`order_product`.`order_id` = $id"
        );

        echo json_encode($order_products);
    } catch (Exception $e) {
        var_dump($e);
    }
}elseif (isset($_GET['start']) && isset($_GET['end'])){
    $startDate = $_GET['start'];
    $endDate = $_GET['end'];
    try{
        $orders = $db->join_two_tables_with_date_range(
            "order", "user",
            "user_id", "id",
            "$startDate","$endDate","`order`.* , `user`.name , `user`.profile_picture","`order`.user_id = $user_id");
        $orders_products = $db->join_three_tables_with_date_range(
            "order", "order_product", "product",
            "`order`.`id` = `order_product`.`order_id`",
            "`order_product`.`product_id` = `product`.`id`",
            "$startDate",
            "$endDate",
            "`order_product`.*, `product`.*",
            "`order`.status='processing'"
        );
        $result = [
            "orders"=> $orders,
             "orders_products" => $orders_products
        ];
        if(count($orders_products)> 0){
            echo json_encode($result);
        }else{
            echo json_encode(["message"=>"no data found for this date range"]);
        }
    }catch (Exception $e){

    }
} else { // If no order ID is provided, return all orders
    try {
        $orders = $db->join_two_tables(
            "order", "user",
            "user_id", "id",
            "`order`.* , `user`.name , `user`.profile_picture","`order`.user_id=$user_id"
            );
        $result = ["orders"=> $orders];
        echo json_encode($result);
    } catch (Exception $e) {
        var_dump($e);
    }
}
