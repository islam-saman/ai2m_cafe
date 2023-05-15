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


    $cate_id = $_POST["cateId"];
    $cate_name = $_POST["cateName"];


    try
    {
        $db = new Database(dbUser, dbPass, dbName);
        $is_category_exist = $db->isExisted("category", "id", $cate_id);

        if(!$is_category_exist)
        {
            echo json_encode(array("status"=> 404, "error" => "No Category Found"));
            exit;
        }

        $update_category = $db->updateById("category", ["name"], [$cate_name], $cate_id);

        if($update_category)
        {
            echo json_encode(array("status"=> 200, "success" => "updated successfully"));
        }
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>