<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    $userId = $_GET["userId"];

    try
    {
        $database = new Database(dbUser, dbPass, dbName);
        $db_connection = $database->connect();

        if(!empty($userId))
            $selectQuery = "SELECT user.id, name, SUM(total) as totalAmount from `order`, user where user.id = $userId GROUP BY user.id;";
        
        else        
            $selectQuery = "SELECT user.id, name, SUM(total) as totalAmount from `order`, user where user.id = user_id GROUP BY user.id;";
    

        $selectStatement = $db_connection->prepare($selectQuery);
        $selectStatement->execute();        

        if($selectStatement->rowCount() != 0)
            $users_list= $selectStatement->fetchALl(PDO::FETCH_ASSOC);
        else
            $users_list = [];    

        echo json_encode($users_list);
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>