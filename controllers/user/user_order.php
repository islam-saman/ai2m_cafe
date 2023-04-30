<?php

    include ("../../helpers/database.php");

    $db = new Database('127.0.0.1', '3306', 'root', 'Mario2022', 'aim2');
    if($db){

        if ($_GET['id']){
            $prd = $db->fetchOne("product","id","$_GET[id]");
            echo json_encode($prd);
        }
    }