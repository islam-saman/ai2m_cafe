<?php

include ("../../helpers/database.php");
include ("../../env.php");

session_start();
if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){

    echo json_encode(["redirect"=>true]);

    exit;
}
$user_id = $_SESSION['id'];

try {
    $db = new Database(dbUser, dbPass, dbName);
    if($db){
        $prd = $db->fetchALl("product");
        echo json_encode(["prd"=>$prd,"user_id"=>$user_id]);
    }
}catch (Exception $e){
    echo $e->getMessage();
}

