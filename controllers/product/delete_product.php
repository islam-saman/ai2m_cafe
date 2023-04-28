<?php 

    // include the env file
    include "../../env.php";
    include "../../helpers/database.php";

    $prodId = $_POST["prodId"];

    try
    {
        $db = new Database(dbHost, dbPort, dbUser, dbPass, dbName);
        $deletedProduct = $db->deleteOne("product","id", $prodId);

        if($deletedProduct)
            echo json_encode("deleted successfully");
        else
            echo json_encode(array("status"=> 404, "error" => "No Product Found"));

    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>