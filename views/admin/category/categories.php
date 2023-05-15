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
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/styles/product.css">
    <link rel="stylesheet" href="../../../public/styles/vanilla-notify.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/styles/style.css">

</head>
<body onload="displayCateories()">
<?php include("../header.php") ?>

    <section class="container">
        <table  class='table text-center'  style='vertical-align: middle;'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </section>
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>
    <script src="../../../public/js/product.js"></script>

</body>
</html>
