<?php include("../../helpers/include_with_variable.php") ?>
<?php include_with_variable('head.php', array('title' => 'Home')); ?>
<?php include ("./header.php") ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/styles/product.css">
    <link rel="stylesheet" href="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.css">

</head>
<body onload="fnLoader()">
    <section class="container">
        <div class="mb-3 row">
            <label for="usersList" class="col-4 col-form-label">Users</label>
            <div class="col-4  justify-content-center align-items-center">
                    <div class="d-flex justify-content-center mb-5">
                        <div class="mx-3">
                            <label for="start">Start Date:</label>
                            <input type="date" name="start" id="start" class="form-control" style="font-size: 2rem">
                        </div>
                        <div class="mx-3">
                            <label for="end">End Date:</label>
                            <input type="date" name="end" id="end" class="form-control" style="font-size: 2rem">
                        </div>
                    </div>

                <div class="d-flex justify-content-center align-items-baseline">
                    <button class="btn btn-success fs-4 mt-4 mx-4" onclick="filterOrders()" style="height: 50px; width: 150px;">Filter</button>
                    <select class="form-select" name="categoryId" aria-label="Default select example" id="usersList"  oninput="displayUsers(this)" style="width: 300px">
                    <option disabled selected>Choose User</option>
                    <option value="">All user</option>
                </select>
                <span id="userIdIsRquried" class="text-danger"></span>
                <span class="text-danger"></span>
                </div>
            </div>

        </div>

        <table  class='table text-center'  style='vertical-align: middle;'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
        <table class="table table-responsive table-borderless">
            <thead>
            <tr class="bg-light">
                <th scope="col">Date</th>
                <th scope="col">Total Price</th>
            </tr>
            </thead>
            <tbody id="orderData">

            </tbody>
        </table>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>
    <script src="../../public/js/user/my_order/order.js"></script>
    <script src="../../public/js/admin/checks.js"></script>


</body>
</html>
