<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

 include '../../helpers/database.php';
 include '../../env.php';

session_start();
if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
    echo json_encode(["redirect"=>true]);
    exit;
}


try
{
    $db = new Database(dbUser,dbPass,dbName); 
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