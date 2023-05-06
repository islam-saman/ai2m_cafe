<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

 include '../../helpers/database.php';

 
$Data = json_decode($_POST["data"], true);

$secretkey               = $Data["secretkey"];

try
{
    $db = new Database("root","1191997","ai2m"); 
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