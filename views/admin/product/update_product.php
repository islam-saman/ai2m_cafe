<?php
    include "../../../env.php";
    include "../../../helpers/database.php";
    include "../../../helpers/product_forms_validation.php";
    include "../../../helpers/include_with_variable.php";
    
    session_start();
    $user_id = $_SESSION['id'];
    $db = new Database(dbUser, dbPass, dbName);
    
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        header("location:http://localhost/ai2m_cafe/views/login.php");
        exit;
    }
    else
    {
        $userData = $db->fetchOne('user', 'id', $user_id);
        if(!$userData["is_admin"])
        {
            header("location:http://localhost/ai2m_cafe/views/login.php");
            exit;
        }
        
    }
    
    include_with_variable('../head.php', array('title' => 'Update Product'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body onload="getUpdateForm()" id="header">
<?php include ("../header.php") ?>

    <script src="../../../public/js/product.js"></script>
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>

</body>
</html>
