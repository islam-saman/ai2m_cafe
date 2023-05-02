<?php

include ("../../helpers/database.php");

$db = new Database('127.0.0.1', '3306', 'root', 'Mario2022', 'aim2');
$order_data = json_decode($_POST['data'], true);

if($db){
    if ($order_data){
        $order = $db->insert("order",
            ["date","room","ext","user_id","total","comment"],
            [
                $order_data['date'],
                $order_data['room'],
                $order_data['ext'],
                $order_data['user_id'],
                $order_data['total'],
                $order_data['comment']
            ]
        );
        echo json_encode($order);
    }else{
        echo json_encode(array("error" => "Error"));
    }
}