<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    $prodId = $_POST["prodId"];

    try
    {
        $db = new Database(dbUser, dbPass, dbName);
        $oldProductDetiles = $db->fetchOne("product", "id", "$prodId");

        if($oldProductDetiles)
            $oldProductImage = $oldProductDetiles["image"];
        else
        {
            echo json_encode(array("status"=> 404, "error" => "No Product Found"));
            exit;
        }

        $deletedProduct = $db->deleteOne("product","id", $prodId);

        if($deletedProduct)
        {
            if($oldProductImage != "public/images/product_defualt_image.jpeg")
                unlink("../../../{$oldProductImage}");

            echo json_encode("deleted successfully");
        }
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>