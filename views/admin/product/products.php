<?php include("../../../helpers/include_with_variable.php") ?>
<?php include_with_variable('../head.php', array('title' => 'add product')); ?>
<?php include ("../header.php") ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/styles/vanilla-notify.css">
    <link rel="stylesheet" href="../../../public/styles/product.css">
    <link rel="stylesheet" href="../../../public/styles/style.css">

</head>
<body onload="displayProducts()">
    <div class="container mt-5">
        <h1>Product List 
            <a type="button" href='../product/add_product.php' class='btn btn-primary'>Add New</a>
        </h1>
        <table  class='table text-center'  style='vertical-align: middle;'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>CategoryId</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>
    <script src="../../../public/js/product.js"></script>
</body>
</html>
