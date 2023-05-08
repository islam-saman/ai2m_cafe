
<?php
header("Access-Control-Allow-Origin: *");
include '../helpers/database.php';


$newData                 = json_decode($_POST["changepass"], true);
$secretkey               = $newData["secretkey"];
$newpassword             = $newData["newpassword"];


  $popup_errors = array();

   $newpattern = " /^[a-z _]{8}$/ " ;
if(empty($newpassword) and isset($newpassword))
    $popup_errors['Newpassword']='password is required';

elseif(!preg_match($newpattern,$newpassword))
    $popup_errors['Newpassword']='error password';




//  validate secretkey
if(empty($secretkey) and isset($secretkey))
    $popup_errors['Secretkey']='secretkey is required';




 if($popup_errors)
  {
     echo json_encode(array("status"=> 401, "errors" => $popup_errors));
  }
else
{
    try
    {
        $db = new Database("root","1191997","ai2m"); 
        if($db)
        {
           // first check of the category is existed or not
            $is_secretkey_found = $db->isExisted("user", "secret_key",$secretkey  );

            if($is_secretkey_found)
            {
                $new_Data = $db->fetchOne("user", "secret_key",$secretkey);
                $updateResualt = $db->updateById("user", ["password"] ,[$newpassword],$new_Data["id"]);
                echo json_encode(array("status"=> 200, "success" => "Change Password successfully"));
            }
            else
            {
                $popup_errors["Secretkey"] = "This Secretkey is Not Found";
                echo json_encode(array("status"=> 404, "errors" => $popup_errors));
                exit;
            }
        }
        
    }
    catch(Exception $dbConError)
    {
        $dbConError->getTrace();
    }

    
} 








?>