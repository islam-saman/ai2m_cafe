<?php 

     header("Access-Control-Allow-Origin: *");

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


    $category_name       = $_POST["cateName"];
    $name_pattern = "/^[A-Za-z0-9]+$/";


    // do some vaildation on the product detiles
    if(!isset($category_name) or empty($category_name) )
        $form_errors["cateError"] = "Product name is rquired ";
        
    elseif(!preg_match($name_pattern, $category_name) )
        $form_errors["cateError"] = "alphabetic character and numbers only";
    

    if($form_errors)
    {
        echo json_encode(array("status"=> 400, "errors" => $form_errors));
    }
    else
    {
        try
        {
            $db = new Database(dbUser, dbPass, dbName);    
            if($db)
            {
                
                // first check of the category is existed or not
                $is_category_found = $db->isExisted("category", "name", $category_name);
                if($is_category_found)
                {
                    $form_errors["cateError"] = "Category is already exist";
                    echo json_encode(array("status"=> 409, "errors" => $form_errors));
                    exit;
                }

                $added_category = $db->insert("category", ["name"], [$category_name]);
                if($added_category)
                {
                    $newCategory = $db->fetchLastRow("category");
                    echo json_encode(array("status"=> 200, "success" => $newCategory));
                }
            }
            
        }
        catch(Exception $dbConError)
        {
            $dbConError->getTrace();
        }        
    }

?>



