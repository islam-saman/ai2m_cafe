<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

 include '../../helpers/database.php';
 include '../../env.php';

 
$Data = json_decode($_POST["data"], true);

$secretkey               = $Data["secretkey"];

try
{
    $db = new Database(dbUser,dbPass,dbName); 
    if($db)
    {

       // first check of the category is existed or not
        $delete_one = $db->deleteOne("user", "secret_key",$secretkey  );
        if($delete_one)
        {
            echo json_encode(array("status"=> 200, "success" => "User has been Deleted successfully"));
        }
        else
        {
            echo json_encode(array("status"=> 404, "errors" => "cant delete try again later"));
        }
    }
    
}
catch(Exception $dbConError)
{
    $dbConError->getTrace();
}

