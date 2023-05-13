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

    $userInput = json_decode($_POST["user"], true);

    
    $name               = $userInput["Name"];
    $email              = $userInput["email"];
    $password           = $userInput["password"];
    $confirm_password   = $userInput["ConfirmPassword"];
    $room               = $userInput["Room"];
    $ext                = $userInput["Ext"];  
    

    if($_FILES)
    {
    $image              = $_FILES["userImage"]["name"];
    $imageExtension     = pathinfo($image)["extension"];
    $imageOldPath       = $_FILES["userImage"]["tmp_name"];
    }

    
    
    
    $form_errors = array();
    
    
    if(!isset($image) or empty($image))
    {
        $image = "../public/images/default_image.avif";
    }
    elseif($_FILES["userImage"]["size"] == 0)
    {
        $form_errors["Image_error"] = "The maximum size is 2MB";
    
    }
    else
    {
        $uniqueImageName = time();
        $image = "../public/uploads/{$uniqueImageName}.{$imageExtension}";
    } 



if(empty($name) and isset($name)){
    $form_errors['Name']='Name is required';
}
elseif(strlen($name) < 4 )
{
    $form_errors['Name']='Name must be at least 4 characters';
}
elseif(strlen($name) > 45)
{
    $form_errors['Name']='Name not exceed 45 characters';
}


// validate email
if(empty($email) and isset($email)){
    $form_errors['email']='email is required';
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $form_errors['email']='email must match example@example.com';
}


// validate password
$pattern = " /^[a-z _]{8}$/" ;
if(empty($password) and isset($password)){
    $form_errors['password']='password is required';
}
elseif(!preg_match($pattern,$password)){
$form_errors['password']='error password';
}

// validate confirm_password
if(empty($confirm_password) and isset($confirm_password)){
    $form_errors['ConfirmPassword']='ConfirmPassword is required';
}
elseif($confirm_password != $password) {
    $form_errors['ConfirmPassword']='Confirm_Password not matched ';
}


//  validate room
if(empty($room) and isset($room)){
    $form_errors['Room']='Room is required';
}

// validate Ext
if(empty($ext) and isset($ext)){
    $form_errors['Ext']='Ext is required';
}








if($form_errors)
    {
        echo json_encode(array("status"=> 401, "errors" => $form_errors));
    }
    else
    {
        try
        {
            $db = new Database(dbUser,dbPass,dbName); 
            if($db)
            {
               // first check of the category is existed or not
                $is_email_found = $db->isExisted("user", "email", $userInput["email"]);
                if($is_email_found)
                {
                    $form_errors["email"] = "This email is already registered";
                    echo json_encode(array("status"=> 404, "errors" => $form_errors));
                    exit;
                }
                
                
                
                    try
                    {
                        if($_FILES)
                        {
                            $uploaded = move_uploaded_file($imageOldPath, "../$image");
                        }else{
                            $image = "../public/images/default_image.avif";
                        }

                        $columns =['name','email','password','room_no','ext','secret_key','is_admin','profile_picture'];
                        $columnsValue =[$userInput["Name"],$userInput["email"],$userInput["password"],$userInput["Room"],$userInput["Ext"],time(),"0",$image];
                        $adduser =  $db->insert("user",$columns,$columnsValue);
                        
                        if($adduser){

                            echo json_encode(array("status"=> 200, "success" => "User has been added successfully"));
                        }
                    }
                    catch (Exception $movingImageError)
                    {
                        $form_errors["categoryNotFound"] = "Greate";
                        echo json_encode($form_errors);
                        $movingImageError->getMessage();
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






