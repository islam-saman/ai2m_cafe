<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";


    session_start();
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        echo json_encode(array("status"=> 403, "error" => "Please, Login First"));
        exit;
    }
    
    $user_id = $_SESSION['id'];
    $db = new Database(dbUser, dbPass, dbName);

    //// Check if user is an admin
    $userData = $db->fetchOne('user', 'id', $user_id);

    // if(!$userData["is_admin"]){
    //     echo json_encode(array("status"=> 401, "error" => "You are not an Admin, the action has been reported"));
    //     exit;
    // }


    try
    {
        $productList = $db->fetchALl("product");
        echo json_encode(array("status"=> 200, "productList" => $productList));
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>