<?php
include '../../../env.php';
include '../../../helpers/database.php';
$id = $_GET['id'];
$db = new Database(dbUser,dbPass,dbName);
$deleted = $db->deleteOne("order","id",$id);
if($deleted){
    $message = "Order deleted";
    echo json_encode(["message" => $message, "redirect" => "http://localhost/ai2m_cafe/views/user/order.php"]);
}else{
    $message = "Order not deleted";
    echo json_encode(["message" =>"Order not deleted"]);
}
