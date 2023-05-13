<?php include("../../../helpers/include_with_variable.php") ?>
<?php include_with_variable('../head.php', array('title' => 'Add Product')); ?>

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
    <link rel="stylesheet" href="../../../public/styles/vanilla-notify.css">
</head>
<body onload="loadCategoriesList()">
<?php include ("../header.php") ?>

    <section class="container">
        <form class="add-product-form" id="adding-form" method="post" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="productName" class="col-4 col-form-label">Product</label>
                <div class="col-8">
                    <input  type="text" name="productName" class="form-control" id="productName" oninput="productDetilesBuilder(this)">
                    <span id="nameIsRquried" class="text-danger"></span>
                    <span id="invaildName" class="text-danger"></span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="productPrice" class="col-4 col-form-label">Price</label>
                <div class="col-6">
                    <input  type="number" min="1" name="productPrice" class="form-control" id="productPrice"  oninput="productDetilesBuilder(this)">
                    <span id="priceIsRquried" class="text-danger"></span>
                    <span id="invalidPrice" class="text-danger"></span>
                </div>
                <label for="productPrice" class="col-2 col-form-label text-right">EGP</label>

            </div>            

            <div class="mb-3 row">
                <label for="productCateogry" class="col-4 col-form-label">Cateogry</label>
                <div class="col-4">
                    <select class="form-select" name="categoryId" aria-label="Default select example" id="productCateogry"  oninput="productDetilesBuilder(this)">
                        <option disabled selected>Choose a Cateogry</option>
                    </select>
                    <span id="categoryIdIsRquried" class="text-danger"></span>
                    <span class="text-danger"></span>
                </div>
                <button type="button" class="btn btn-outline-dark col-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    new category?
                </button>
            </div>

            <div class="mb-3 row">
                <label for="productImage" class="col-4 col-form-label">Product Image</label>
                <div class="col-8">
                    <input class="form-control" type="file" id="productImage" name="productImage"  accept=".jpg, .png, .jpeg">
                    <span id="allowedImages" class="text-danger"></span>
                    <span id="ImageSize" class="text-danger"></span>

                </div>
            </div>
            <div class="mb-3 row">
                <button id="subButton" onclick="addNewProduct()" class="btn btn-primary col-4">Submit</button>
                <button  type="reset" class="btn btn-dark col-4">Reset</button>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add new category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <input type="text" placeholder="Cateogry Name" name="categoryName" class="categoryNameInput" oninput="getCategoryValue(this)">
                        <span id="cateError" class="text-danger"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addCategory()">Add</button>
                    </div>
                </div>
            </div>
        </div>        
    </section>
    <script src="https://unpkg.com/rxjs@^7/dist/bundles/rxjs.umd.min.js"></script>
    <script src="https://rawgit.com/MLaritz/Vanilla-Notify/master/dist/vanilla-notify.min.js"></script>
    <script src="../../../public/js/product.js"></script>

</body>
</html>
