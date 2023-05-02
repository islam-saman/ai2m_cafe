<?php 
     header("Access-Control-Allow-Origin: *");

    // include the env file
    include "../../env.php";
    include "../../helpers/database.php";
    include "../../helpers/product_forms_validation.php";

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

                // first check of the category is existed or not
                $is_category_found = $db->isExisted("category", "id", $productDetiles[4]);
                if(!$is_category_found)
                {
                    $form_errors["categoryNotFound"] = "given category is not found ";
                    echo json_encode(array("status"=> 404, "errors" => $form_errors));
                    exit;
                }



                $product_row_columns = ["name", "price", "image","is_available", "category_id" ];
                $product_row_values = $productDetiles;
                
                $added_product = $db->insert("product", $product_row_columns, $product_row_values);
                
                if($added_product)
                {
                    try
                    {
                        $uploaded = move_uploaded_file($imageOldPath, "../../$prodcutImage");
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

// extracting the product info from the $_POST array
    // $name               = $productInput["productName"];
    // $price              = $productInput["productPrice"];
    // $category_id        = $productInput["categoryId"];
    // $is_available       = $productInput["isAvailable"];
    // $image              = $_FILES["productImage"]["name"];
    // $imageExtension     = pathinfo($image)["extension"];
    // $imageOldPath       = $_FILES["productImage"]["tmp_name"];

    // $form_errors = array();
    
    // $name_pattern = "/^[A-Za-z0-9]+$/";
    // $allowed_imageExt = ["png", "jpeg", "jpg"];


    // // do some vaildation on the product detiles
    // if(!isset($name) or empty($name) )
    // {
    //     $form_errors["nameIsRquried"] = "Product name is rquired ";
        
    // }
    
    // elseif(!preg_match($name_pattern, $name) )
    // {
    //     $form_errors["invaildName"] = "alphabetic character and numbers only";
    // }    

    // if(!isset($price) or empty($price) )
    // {
    //     $form_errors["priceIsRquried"] = "Price is rquired ";
    // }
    
    // elseif($price < 0)
    // {
    //     $form_errors["invalidPrice"] = "The price cannot be negative";
    // }       

    // if(!isset($category_id) or empty($category_id) )
    // {
    //     $form_errors["categoryIdIsRquried"] = "category is rquired ";
    // }


    // if(!isset($image) or empty($image))
    // {
    //     $image = "public/images/product_defualt_image.jpeg";
    // }
    // elseif($_FILES["productImage"]["size"] == 0)
    // {
    //     $form_errors["ImageSize"] = "The maximum size is 2MB";

    // }
    // elseif(in_array($imageExtension, $allowed_imageExt) == false)
    // {
    //     $form_errors["allowedImages"] = "Allowed Images are png, jpeg, jpg only";
    //     $form_errors["ImageSize"] = $_FILES["productImage"]['error'];
    // }
    // else
    // {
    //     $uniqueImageName = time();
    //     $image = "public/uploads/{$uniqueImageName}.{$imageExtension}";
    // }

?>



