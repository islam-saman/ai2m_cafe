<?php

    include ("../../helpers/database.php");
    include ("../../env.php");


session_start();
$user_id = $_SESSION['id'];

$db = new Database(dbUser, dbPass, dbName);
    if($db){
        if ($_GET['id']){
            $prd = $db->fetchOne("product","id","$_GET[id]");
            echo json_encode($prd);
        }
    }