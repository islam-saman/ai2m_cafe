<?php include("../../helpers/include_with_variable.php") ?>

<?php include_with_variable('head.php', array('title' => 'Eidt User','link'=>'../../public/styles/register.css','not'=>"https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.css")); ?>


<body>
   <?php include 'header.php' ?>
  <section style="background-color: #eee;width: 100%;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4" id="header"></p>

                  <form class="mx-1 mx-md-4" id="edit_user" method="post" enctype="multipart/form-data" >

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0 d-flex justify-content-center align-items-baseline">
                          <i class="fas fa-user fa-lg  fa-fw "></i>
                          <input class="form-control mx-2" type="text" name="Name" placeholder="Name" id="name" oninput="userDetilesBuilder(this)" >
                          <span id="Name" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0 d-flex justify-content-center align-items-baseline">
                      <i class="fas fa-envelope fa-lg  fa-fw "></i>
                        <input class="form-control mx-2" type="email" name="email" id="user_email" placeholder="example@example.com" oninput="userDetilesBuilder(this)" >
                        <span id="email" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0 d-flex justify-content-center align-items-baseline">
                        <i class="fas fa-lock fa-lg  fa-fw "></i>
                        <input class="form-control mx-2" type="password" name="password" placeholder="Password" id="user_password" oninput="userDetilesBuilder(this)">
                        <span id="password" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0 d-flex justify-content-center align-items-baseline">
                      <i class="fas fa-key fa-lg  fa-fw "></i>
                        <input class="form-control mx-2" type="password" name="ConfirmPassword" placeholder="Confirm Password" id="cpassword" oninput="userDetilesBuilder(this)">
                        <span id="ConfirmPassword" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0 d-flex justify-content-center align-items-baseline">
                      <i class="fas fa-home fa-lg  fa-fw"></i>
                          <input class="form-control mx-2" type="text" name="Room"  placeholder="Room_No" id="Room_No" oninput="userDetilesBuilder(this)">
                          <span id="Room" class="text-danger"></span>

                        </div>
                      </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0 d-flex justify-content-center align-items-baseline">
                          <i class="fas fa-user fa-lg  fa-fw "></i>
                          <input class="form-control mx-2" type="text" name="Ext" id="ext" placeholder="Ext" oninput="userDetilesBuilder(this)">
                          <span id="Ext" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0 d-flex justify-content-center align-items-baseline">
                        <i class="fas fa-file-image" style="font-size: 20px;"></i>
                        <input class="form-control mx-2 bg-light text-dark" type="file" name="image" id="image">
                        <span id="Image_error" class="text-danger"></span>
                      </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button type="submit" onclick="saveNewData()" class="btn btn-outline-primary btn-lg">Save</button>
                    </div>

                  </form>

                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                  <img  src="../../public/images/r.jpg" class="img-fluid" alt="Register image">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  
        
       
   
<!--    <script src="../../public/js/bootstrap5.js"></script> -->
    <script src="../../public/js/admin/editUser.js"></script>  
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>
</body>