



<?php include("../../helpers/include_with_variable.php") ?>

 <?php include_with_variable('head.php', array('title' => 'All user','link'=>'../../public/styles/all_user.css','not'=>"https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.css")); ?>

 <?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../../helpers/database.php';




$db = new Database("localhost",3306,"root","1191997","ai2m"); 

try{
    
    $users= $db->fetchALl("user","name,room_no,secret_key,profile_picture");


  echo'<body>
    <div class="container">
        <div class="d-flex justify-content-between alluser my-5">
        <h1 style="font-size: 40px;">All User</h1>
        <a href="addUser.php" class="btn btn-primary">Add new user </a>
        </div>
        <ul class="responsive-table">
          <li class="table-header">
            <div class="col col-1">Name</div>
            <div class="col col-1">Room</div>
            <div class="col col-1">SecretKey</div>
            <div class="col col-3">Image</div>
            <div class="col col-4">Action</div>
          </li>
          ';
          foreach ($users as $user){
            echo ' <li class="table-row"> ';
               foreach ($user as $key=>$info){
                if($key == "ext")
                  echo "<div class='col col-2 h4' data-label='Job Id'>{$info}</div>";
                elseif($key == "profile_picture")
                  echo "<div class='col col-3' data-label='Job Id'><img width='100' height='100'  src='../$info'></div>";
                else
                  echo "<div class='col col-1 h4' data-label='Job Id'>{$info}</div>";
               }

           echo" 
             <div class='col col-4' data-label='Job Id'>
             <a class=' btn btn-warning' href='#'>Edit</a>
             <a class=' btn btn-danger' href='#' onclick='deleteuser({$user['secret_key']})' >Delete</a>
             </div>
           </li>";
            }
        echo "</ul>";
       echo  "</div>";
      echo  "</body> " ;
            
}catch (Exception $e){
    echo $e->getMessage();
}


?>
     <script src="../../public/js/bootstrap5.js"></script> 
     <script src="../../public/js/all_user.js"></script> 
     <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>