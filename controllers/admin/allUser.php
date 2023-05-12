<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

 include '../../helpers/auth.php';
 include '../../env.php';

session_start();
if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
    echo json_encode(["redirect"=>true]);
    exit;
}

$user_id = $_SESSION['id'];
$db = new Database(dbUser, dbPass, dbName);
//// Check if user is an admin
$is_admin = check_admin($db, 'user', 'id', $user_id);

if(!$is_admin){
    echo json_encode(["is_admin"=>false]);
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