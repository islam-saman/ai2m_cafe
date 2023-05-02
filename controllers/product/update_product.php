<?php 
    header("Access-Control-Allow-Origin: *");

    // include the env file
    include "../../env.php";
    include "../../helpers/database.php";
    include "../../helpers/product_forms_validation.php";
    
    
    
    $prodId = $_POST["prodId"];

    $productInput       = json_decode($_POST["product"], true);
    $image              = $_FILES["productImage"]["name"];
    $imageExtension     = pathinfo($image)["extension"];
    $imageOldPath       = $_FILES["productImage"]["tmp_name"];

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
            $db = new Database(dbHost, dbPort, dbUser,dbPass, dbName);    
            if($db)
            {
                $productDetiles = $formValidationResualt[1];
                $prodcutImage = $productDetiles[2];

                // first check of the product is exist or not
                $oldProductDetiles = $db->fetchOne("product", "id", $prodId);
                if($oldProductDetiles)
                    $oldProductImage = $oldProductDetiles["image"];
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
                    if($prodcutImage != "public/images/product_defualt_image.jpeg")
                    {
                        try
                        {
                            $uploaded = move_uploaded_file($imageOldPath, "../../$prodcutImage");
                            if($oldProductImage != "public/images/product_defualt_image.jpeg")
                                unlink("../../{$oldProductImage}");
                            
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