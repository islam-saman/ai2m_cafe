<?php 

function validateProductForm($productInput)
{
    // extracting the product info from the $_POST array
    $name               = $productInput["productName"];
    $price              = $productInput["productPrice"];
    $category_id        = $productInput["categoryId"];
    $is_available       = $productInput["isAvailable"];
    $image              = $_FILES["productImage"]["name"];
    $imageExtension     = pathinfo($image)["extension"];
    $imageOldPath       = $_FILES["productImage"]["tmp_name"];

    $form_errors = array();
    $name_pattern = "/^[A-Za-z0-9]+$/";
    $allowed_imageExt = ["png", "jpeg", "jpg"];


    // do some vaildation on the product detiles
    if(!isset($name) or empty($name) )
        $form_errors["nameIsRquried"] = "Product name is rquired ";
        
    elseif(!preg_match($name_pattern, $name) )
        $form_errors["invaildName"] = "alphabetic character and numbers only";
    

    if(!isset($price) or empty($price) )
        $form_errors["priceIsRquried"] = "Price is rquired ";
    
    elseif($price < 0)
        $form_errors["invalidPrice"] = "The price cannot be negative";
           

    if(!isset($category_id) or empty($category_id) )
        $form_errors["categoryIdIsRquried"] = "category is rquired ";
    

    if(!isset($image) or empty($image))
        $image = "public/images/product_defualt_image.jpeg";
    
    elseif($_FILES["productImage"]["size"] == 0)
        $form_errors["ImageSize"] = "The maximum size is 2MB";

    
    elseif(in_array($imageExtension, $allowed_imageExt) == false)
    {
        $form_errors["allowedImages"] = "Allowed Images are png, jpeg, jpg only";
        $form_errors["ImageSize"] = $_FILES["productImage"]['error'];
    }
    else
    {
        $uniqueImageName = time();
        $image = "public/uploads/{$uniqueImageName}.{$imageExtension}";
    }
  
    if($form_errors)
    {
        return [false, $form_errors];
    }
    else
    {
        $productInfo = [ $name , $price, $image, $is_available, $category_id];
        return [true, $productInfo];
    }    
}



?>