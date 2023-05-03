<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    $prodId = $_POST["prodId"];
    try
    {
        $db = new Database(dbUser, dbPass, dbName);

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