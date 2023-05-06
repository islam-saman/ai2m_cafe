<?php

include ("../../env.php");
include ("../../helpers/auth.php");

session_start();
if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){

    echo json_encode(["redirect"=>true]);

    exit;
}
$user_id = $_SESSION['id'];
$db = new Database(dbUser, dbPass, dbName);

$is_admin = check_admin($db,"user","id",$user_id);

if (!$is_admin){
    echo json_encode(["is_admin"=> false]);
    exit;
}

try {
    if($db){
        $prd = $db->fetchALl("product");
        echo json_encode(["prd"=>$prd,"user_id"=>$user_id]);
    }
}catch (Exception $e){
    echo $e->getMessage();
}

