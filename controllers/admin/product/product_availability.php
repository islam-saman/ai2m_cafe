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

    if(!$userData["is_admin"]){
        echo json_encode(array("status"=> 401, "error" => "You are not an Admin, the action has been reported"));
        exit;
    }


    $prodId = $_POST["prodId"];
    try
    {

        $productDetiles = $db->fetchOne("product", "id", $prodId);

        if($productDetiles)
        {
            if($productDetiles["is_available"])
                $isProductAvailable = 0;
            else
                $isProductAvailable = 1;
        }
        else
        {
            echo json_encode(array("status"=> 404, "error" => "No Product Found"));
            exit;
        }

        
        $updateProductAvailablity = $db->updateById("product",["is_available"],[$isProductAvailable], $prodId);

        if($updateProductAvailablity)
            echo json_encode(array("status"=> 200, "success" => $isProductAvailable));
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>