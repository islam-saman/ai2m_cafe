
<?php include ("./head.php")?>

<header class="header">

    <a  href="../../views/admin/index.php" class="logo"> <i class="ri-store-2-line"></i> The Garden Cafe </a>

    <nav class="navbar">
        <a href="../../views/admin/index.php">home</a>
        <a href="#about">about</a>
        <a href="#popular">popular</a>
        <a href="#menu">menu</a>
        <a href="/ai2m_cafe/views/admin/manual_order.php">order</a>
        <a href="#blogs">blogs</a>
    </nav>

    <div class="d-flex justify-content-center align-items-center">
        <div>
            <div class="me-2" id="login-btn">
                <img width="60" height="60" style="border-radius: 30px" id="image-user" />
            </div>
        </div>

        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <h6 id="username"></h6>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item btn btn-ligh" href="" onclick="logout()"> Logout</a></li>
            </ul>
        </div>
    </div>

</header>

<script src="../../public/js/logout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
