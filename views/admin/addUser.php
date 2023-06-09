

<?php include("../../helpers/include_with_variable.php") ?>

<?php include_with_variable('head.php', array('title' => 'Add User','link'=>'../../public/styles/register.css','not'=>"../../public/styles/vanilla-notify.css")); ?>

<body onload="checkuser()">
  <?php include 'header.php' ?>
  <section style="background-color: #eee;width: 100%;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Add User</p>

                  <form class="mx-1 mx-md-4" id="add_user" method="post" enctype="multipart/form-data" >
    

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg  fa-fw "></i>
                      <div class="form-outline flex-fill ">
                        <input class="form-control" type="text" name="Name" placeholder="Name" id="name" oninput="userDetilesBuilder(this)" >
                        <span id="Name" class="text-danger"></span>
                      </div>
                    </div>
                  


                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg  fa-fw "></i>
                      <div class="form-outline flex-fill mb-0">
                        <input class="form-control" type="email" name="email" id="user_email" placeholder="example@example.com" oninput="userDetilesBuilder(this)" > 
                        <span id="email" class="text-danger"></span>
                      </div>
                    </div>


                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg  fa-fw "></i>
                      <div class="form-outline flex-fill mb-0">
                        <input class="form-control" type="password" name="password" placeholder="Password" id="user_password" oninput="userDetilesBuilder(this)"> 
                        <span id="password" class="text-danger"></span>
                      </div>
                    </div>


                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-key fa-lg  fa-fw "></i>
                      <div class="form-outline flex-fill mb-0">
                        <input class="form-control" type="password" name="ConfirmPassword" placeholder="Confirm Password" id="cpassword" oninput="userDetilesBuilder(this)">
                        <span id="ConfirmPassword" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-home fa-lg  fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input class="form-control" type="text" name="Room"  placeholder="Room_No" id="Room_No" oninput="userDetilesBuilder(this)">
                          <span id="Room" class="text-danger"></span>

                        </div>
                      </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg  fa-fw "></i>
                      <div class="form-outline flex-fill mb-0">
                        <input class="form-control" type="text" name="Ext" id="ext" placeholder="Ext" oninput="userDetilesBuilder(this)">
                        <span id="Ext" class="text-danger"></span>

                      </div>
                    </div>


                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-file-image" style="font-size: 20px;"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="file" name="image" id="image" >
                        <span id="Image_error" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <p>Back to Users Page?</p><a href="./all_user.php" style="color:blue;">Click Here</a>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button type="submit" onclick="adduser()" class="btn btn-primary btn-lg">Save</button>
                      <button type="reset" class="btn btn-primary btn-lg ms-3">Reset</button>
                    </div>

                  </form>

            

                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                  <img  src="../../public/images/def_image.avif.jpg" class="img-fluid" alt="Register image">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  
        
       
   <script>
    async function checkuser(){

     let addingResualt = await fetch("../../controllers/admin/addUser.php")
      if(addingResualt.ok)
      {
          const JsonResualt = await addingResualt.json();
          if(JsonResualt['redirect'] == true){
              window.location.href = "http://localhost/ai2m_cafe/views/login.php"
          }
          else if (JsonResualt['is_admin']===false){
                window.location.href = "http://localhost/ai2m_cafe/views/login.php";
          }
      }
    }

</script>
    <script src="../../public/js/bootstrap5.js"></script> 
    <script src="../../public/js/admin/addUser.js"></script> 
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>
</body>
