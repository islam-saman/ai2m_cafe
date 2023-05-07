<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    try
    {
        $db = new Database(dbUser, dbPass, dbName);
        $category_list = $db->fetchALl("category");
        echo json_encode($category_list);

    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>