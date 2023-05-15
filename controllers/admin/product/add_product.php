<?php 

     header("Access-Control-Allow-Origin: *");

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";
    include "../../../helpers/product_forms_validation.php";


    session_start();
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        echo json_encode(array("status"=> 403, "error" => "Please, Login First"));
        exit;
    }
    
    $productInput       = json_decode($_POST["product"], true);
    $image              = $_FILES["productImage"]["name"];
    $imageExtension     = pathinfo($image)["extension"];
    $imageOldPath       = $_FILES["productImage"]["tmp_name"];


    $user_id = $_SESSION['id'];
    $db = new Database(dbUser, dbPass, dbName);

    //// Check if user is an admin
    $userData = $db->fetchOne('user', 'id', $user_id);

    if(!$userData["is_admin"]){
        echo json_encode(array("status"=> 401, "error" => "You are not an Admin, the action has been reported"));
        exit;
    }


    $formValidationResualt = validateProductForm($productInput);
    $formValidateStatues = $formValidationResualt[0];
    
    if(!$formValidateStatues)
    {
        $form_errors = $formValidationResualt[1];
        echo json_encode(array("status"=> 400, "errors" => $form_errors));
    }
    else
    {
        
        try
        {
            // $db = new Database(dbUser, dbPass, dbName);
            if($db)
            {
                $productDetiles = $formValidationResualt[1];
                $prodcutImage = $productDetiles[2];
                
                // first check of the category is existed or not
                $is_category_found = $db->isExisted("category", "id", $productDetiles[4]);
                if(!$is_category_found)
                {
                    echo json_encode(array("status"=> 404, "error" => "given category is not found"));
                    exit;
                }
                
                
                
                $product_row_columns = ["name", "price", "image","is_available", "category_id" ];
                $product_row_values = $productDetiles;
                
                $added_product = $db->insert("product", $product_row_columns, $product_row_values);
                
                if($added_product)
                {
                        try
                        {
                                $uploaded = move_uploaded_file($imageOldPath, "../../../$prodcutImage");
                                $newProduct = $db->fetchLastRow("product");
                                echo json_encode(array("status"=> 200, "success" => $newProduct));
                        }
                        catch (Exception $movingImageError)
                        {
                            $movingImageError->getMessage();
                            exit;
                        } 

                }


            }
            
        }
        catch(Exception $dbConError)
        {
            $dbConError->getTrace();
        }

        
    }    


?>



