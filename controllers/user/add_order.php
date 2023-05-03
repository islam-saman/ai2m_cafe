<?php

include ("../../helpers/database.php");
include ("../../env.php");

$db = new Database(dbUser, dbPass, dbName);
$order_data = json_decode($_POST['data'], true);

if($db){
    if ($order_data){
        $order = $db->getLastRow("order",
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