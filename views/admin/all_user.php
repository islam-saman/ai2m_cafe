
<?php include("../../helpers/include_with_variable.php") ?>

 <?php include_with_variable('head.php', array('title' => 'All user','link'=>'../../public/styles/all_user.css','not'=>"../../public/styles/vanilla-notify.css")); ?>


  <body onload="checkuser()">
   <?php include 'header.php' ?>
    <div  id="body_data">

    </div>
        
       </body>

       <script>
      async function checkuser()
        {
            let alldata = await fetch("../../controllers/admin/allUser.php")
            if(alldata.ok)
              {
                  const JsonResualt = await alldata.json();
              console.log(JsonResualt)
                    
                    if(JsonResualt['redirect']){

                        window.location.href = "http://localhost/ai2m_cafe/views/login.php"
                    }else if (JsonResualt['is_admin']===false){
                      console.log("role",JsonResualt['is_admin'])
                        window.location.href = "http://localhost/ai2m_cafe/views/login.php";
                    }
                }
         }
    </script>
<!--     <script src="../../public/js/bootstrap5.js"></script> -->
    
    <script src="../../public/js/logout.js"></script>
    <script src="../../public/js/admin/all_user.js"></script>
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>