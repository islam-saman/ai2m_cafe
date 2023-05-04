<?php

include ("../../helpers/database.php");
include ("../../env.php");

try {
    $db = new Database(dbUser, dbPass, dbName);
    if($db){
        $prd = $db->fetchALl("product");
        echo json_encode($prd);
    }
}catch (Exception $e){
    echo $e->getMessage();
}

