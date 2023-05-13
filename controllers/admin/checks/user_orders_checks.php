<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    $userId = $_GET["userId"];

    try
    {
        $database = new Database(dbUser, dbPass, dbName);
        $db_connection = $database->connect();

        $selectQuery = "SELECT id, date, total from `order` where user_id = $userId";
        $selectStatement = $db_connection->prepare($selectQuery);
        $selectStatement->execute();        

        if($selectStatement->rowCount() != 0)
            $orders_list= $selectStatement->fetchALl(PDO::FETCH_ASSOC);
        else
            $orders_list = [];    

        echo json_encode($orders_list);
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>