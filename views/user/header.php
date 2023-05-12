
<?php include ("./head.php")?>

<header class="header">

    <!-- <a  href="../../views/admin/index.php" class="logo"> <i class="ri-store-2-line"></i> The Garden Cafe </a> -->

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
        <a class="navbar-brand" href="../../views/admin/index.php" >
            <!-- <i class="ri-store-2-line"></i>  -->
            Casablanca Cafe
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../../views/admin/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">about</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">popular</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">menu</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/ai2m_cafe/views/admin/manual_order.php>">order</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./all_user.php">All User</a>
                </li>

                <li class="nav-item">
                    <div class="d-flex justify-content-center align-items-center">
                            <div class="" id="login-btn">
                                <img width="40" height="40" style="border-radius: 30px" id="image-user" />
                            </div>

                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span id="username"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item btn btn-ligh" href="" onclick="logout()"> Logout</a></li>
                            </ul>
                        </div>
                    </div>

                </li>
            </ul>
        </div>
  </div>
</nav>

    <!-- <nav class="navbar">
        
    </nav> -->


</header>

<script src="../../public/js/logout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
