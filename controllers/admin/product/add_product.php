<?php 
     header("Access-Control-Allow-Origin: *");

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";
    include "../../../helpers/product_forms_validation.php";

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
            // $db = new Database(dbHost, dbPort, dbUser, dbPass, dbName);    
            echo json_encode(array("status"=> 200, "success" => "dbHost"));
            if($db)
            {
                $productDetiles = $formValidationResualt[1];
                $prodcutImage = $productDetiles[2];
                
                // first check of the category is existed or not
                // $is_category_found = $db->fetchOne("category", "id", 1);
                // if(!$is_category_found)
                // {
                    //     $form_errors["categoryNotFound"] = "given category is not found ";
                    //     echo json_encode(array("status"=> 404, "errors" => $form_errors));
                    //     exit;
                    // }
                    
                
                
                // $product_row_columns = ["name", "price", "image","is_available", "category_id" ];
                // $product_row_values = $productDetiles;
                
                // $added_product = $db->insert("product", $product_row_columns, $product_row_values);
    

                // if($added_product)
                // {
                //     try
                //     {
                //         $uploaded = move_uploaded_file($imageOldPath, "../../../$prodcutImage");
                //         $newProduct = $db->fetchLastRow("product");
                //     }
                //     catch (Exception $movingImageError)
                //     {
                //         $movingImageError->getMessage();
                //         exit;
                //     } 

                // }


            }
            
        }
        catch(Exception $dbConError)
        {
            $dbConError->getTrace();
        }

        
    }    


?>



