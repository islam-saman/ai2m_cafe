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

 
$Data = json_decode($_POST["data"], true);

$secretkey               = $Data["secretkey"];

try
{
    $db = new Database(dbUser,dbPass,dbName); 
    if($db)
    {

       // first check of the category is existed or not
        $one_user = $db->fetchOne("user", "secret_key",$secretkey  );
        if($one_user)
        {
            echo json_encode(array("status"=> 200, "data" =>  $one_user));
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