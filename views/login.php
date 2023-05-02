



<?php include("../helpers/include_with_variable.php") ?>
<?php include_with_variable('./admin/head.php', array('title' => 'login','link'=>'../public/styles/login.css','not'=>"https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.css")); ?>

<body>
<div class="login-page mt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <h3 class="mb-3">Login Now</h3>
        <div class="bg-white shadow rounded">
          <div class="row">
            <div class="col-md-7 pe-0">
              <div class="form-left py-5 px-5">

                <form class="row g-4" id="login_form" method="post">
                  <div class="col-12">
                    <label>Email<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-text">
                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      </div>
                      <input type="text" class="form-control" name="email" id="email"  placeholder="Enter Username" oninput="userDetilesBuilder(this)">
                    </div>
                  </div>
                  <span id="Email" class="text-danger"></span>

                  <div class="col-12">
                    <label>Password<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-text">
                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      </div>
                      <input name="password"  type="password" class="form-control"
                        placeholder="Enter Password" id="password" oninput="userDetilesBuilder(this)">

                    </div>
                  </div>
                  <span id="Password" class="text-danger"></span>


                  <div class="col-12">
                    <button type="submit" onclick="loginAction()"
                      class="btn btn-primary px-4 float-end mt-4">login</button>
                  </div>
                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <p>Forget Password?</p><a href="#" onclick="openpopup()">Click Here</a>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-5 ps-0 d-none d-md-block">
              <div class="form-right  text-white text-center pt-5">
                <img src="../public/images/login.jpg" 
                  class="img-fluid" alt="Sample image" id="image">
              </div>
            </div>
          </div>
        </div>
        <p class="text-end text-secondary mt-3">Copyright @team</p>
      </div>
    </div>
  </div>
</div>
</section>
     
        <div class="popup" id="popup">
            <img src="../public/images/404-tick.png" ><br><br>
                    <h3>Change Password</h3>
                    <div class="input-group">
                      <input name="secretkey"  type="text" class="form-control"
                        placeholder="Enter the Secret key" id="secretkey" oninput="newpassDetilesBuilder(this)">
                    </div>
                    <span id="Secretkey" class="text-danger"></span><br><br>
                    
                    <div class="input-group">
                      <div class="input-group-text">
                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      </div>
                      <input name="newpassword"  type="password" class="form-control"
                        placeholder="Enter New Password" id="newpassword" oninput="newpassDetilesBuilder(this)">
                    </div>
                    <span id="Newpassword" class="text-danger"></span>
            <button type="button" onclick="closepopup()" >ok</button>
        </div>



    <script src="../public/js/bootstrap5.js"></script> 
    <script src="../public/js/login.js"></script> 
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>
</body>

