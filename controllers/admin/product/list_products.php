<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    try
    {
        $db = new Database(dbHost, dbPort, dbUser, dbPass, dbName);
        $productList = $db->fetchALl("product");
        echo json_encode($productList);

    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>