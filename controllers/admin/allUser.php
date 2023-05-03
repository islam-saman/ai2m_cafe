<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

 include '../../helpers/database.php';


try
{
    $db = new Database("root","1191997","ai2m"); 
    if($db)
    {
        
       // first check of the category is existed or not

       $users= $db->fetchALl("user","name,room_no,secret_key,profile_picture");

        if($users)
        {
            echo json_encode(array("status"=> 200, "alldata" => $users ));
        }
        elseif($users == [])
        {
            echo json_encode(array("status"=> 200,"alldata" => "empty"));
        }
        else
        {
            echo json_encode(array("status"=> 404, "errors" => "error"));
        }
    }
    
}
catch(Exception $dbConError)
{
    $dbConError->getTrace();
}


?>