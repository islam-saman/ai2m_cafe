<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    session_start();
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        echo json_encode(array("status"=> 403, "error" => "Please, Login First"));
        exit;
    }
    

    $user_id = $_SESSION['id'];
    $db = new Database(dbUser, dbPass, dbName);

    //// Check if user is an admin
    $userData = $db->fetchOne('user', 'id', $user_id);

    if(!$userData["is_admin"]){
        echo json_encode(array("status"=> 401, "error" => "You are not an Admin, the action has been reported"));
        exit;
    }


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