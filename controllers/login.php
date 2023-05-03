<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

include '../helpers/database.php';

$userInput = json_decode($_POST["data"], true);

$email              = $userInput["email"];
$password           = $userInput["password"];
$form_errors = array();

// validate email
if(empty($email) and isset($email)){
    $form_errors['Email']='email is required';
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $form_errors['Email']='email must match example@example.com';
}

// validate password
$pattern = " /^[a-z _]{8}$/" ;
if(empty($password) and isset($password)){
    $form_errors['Password']='password is required';
}
elseif(!preg_match($pattern,$password)){
$form_errors['Password']='error password';
}

    if($form_errors)
    {
        echo json_encode(array("status"=> 401, "errors" => $form_errors));
    }
    else
    {
        try
        {
            $db = new Database("root","1191997","ai2m"); 
            if($db)
            {

    
               // first check of the category is existed or not
                $is_email_found = $db->isExisted("user", "email", $userInput["email"]);
        
                if($is_email_found)
                {
                    $Data = $db->fetchOne("user", "email", $userInput["email"]);
                    if($Data["password"] != $userInput["password"])
                    {
                        $form_errors["Password"] = "Wrong password";
                        echo json_encode(array("status"=> 404, "errors" => $form_errors));
                        exit;
                    }
                    else
                    {
                        echo json_encode(array("status"=> 200, "success" => "Login successfully"));
                        session_start();
                        $_SESSION['user_email']=$email;
                        $_SESSION['is_login']=true;
                        $_SESSION['image']=$Data["profile_picture"];
                        $_SESSION['name']=$Data["name"];
                        // header("Location:../views/test.php"); 
                    }
                }
                else
                {
                    $form_errors["Email"] = "This email is Not Found";
                    echo json_encode(array("status"=> 404, "errors" => $form_errors));
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
