<?php

include ("../../helpers/database.php");
include ("../../env.php");



try {
    $db = new Database(dbUser, dbPass, dbName);
    if($db){
            $users = $db->fetchALl("user");
            echo json_encode($users);
    }
}catch (Exception $e){
    echo $e->getMessage();
}

