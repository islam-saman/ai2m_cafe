<?php

include("../helpers/database.php");
include("../env.php");

$db = new Database(dbUser, dbPass, dbName);
    if($_GET['search']){
        $search = $_GET['search'];
        try{
            $products=$db->search('product','name',$search);
            if($products){
                echo json_encode($products);
            }else{
                echo json_encode(['message' =>'No Products Found']);
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }else{
        $products=$db->fetchALl('product');
        echo json_encode($products);
    }


