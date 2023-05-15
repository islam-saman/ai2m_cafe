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
    
    $prodId = $_POST["prodId"];

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
        echo json_encode(array("status"=> 401, "errors" => $form_errors));
    }
    else
    {
        try
        {
            if($db)
            {
                $productDetiles = $formValidationResualt[1];
                $prodcutImage = $productDetiles[2];

                // first check of the product is exist or not
                $oldProductDetiles = $db->fetchOne("product", "id", $prodId);
                if($oldProductDetiles)
                {
                    if(!isset($image) || empty($image))
                    {
                        $oldProductImage = $oldProductDetiles["image"];
                        $productDetiles[2] = $oldProductImage;
                    }
                }
                else
                {
                    echo json_encode(array("status"=> 404, "error" => "given product is not found "));
                    exit;
                }

                // then check of the category is existed or not
                $is_category_found = $db->isExisted("category", "id", $productDetiles[4]);
                if(!$is_category_found)
                {
                    $form_errors["categoryNotFound"] = "given category is not found ";
                    echo json_encode(array("status"=> 404, "errors" => $form_errors));
                    exit;
                }

                $product_row_columns = ["name", "price", "image","is_available", "category_id" ];
                $product_row_values = $productDetiles;
                $update_product = $db->updateById("product", $product_row_columns, $product_row_values, $prodId);
                
                if($update_product)
                {
                    if($prodcutImage && $prodcutImage != "public/images/product_defualt_image.jpeg")
                    {
                        try
                        {
                            $uploaded = move_uploaded_file($imageOldPath, "../../../$prodcutImage");
                            unlink("../../../{$oldProductImage}");
                            
                            }
                            catch (Exception $movingImageError)
                            {
                                $movingImageError->getMessage();
                                exit;
                            } 
 
                    }
                    echo json_encode(array("status"=> 200, "success" => "Product has been updated successfully"));

                }
            }            
        }
        catch(Exception $dbConError)
        {
            $dbConError->getTrace();
        }

        
    }      


?>