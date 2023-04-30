<?php 


echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">';
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../helpers/database.php');


echo "
<nav class='navbar navbar-expand-lg bg-body-tertiary'>
    <div class='container-fluid'>
        <div class='row w-100'>
            <div class='col-12'>
                <div class='d-flex align-items-center justify-content-between'>
                    <a aria-current='page' href='index.php'>
                        <div class='logo'>
                            <img src='../../public/images/products/PHP-logo.svg.png' width='70' height='70'/>
                        </div>
                    </a>
                    <div>
                        <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                            <li class='nav-item'>
                                <a class='btn btn-outline-primary' aria-current='page' href='login.php'>Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../public/styles/user_order.css">
    <link rel="stylesheet" href="../../public/styles/style.css">
    <title>Order</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5">
                <form class="d-flex " role="search">
                    <input class="form-control px-3 py-4 me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success px-5" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <section class="popular" id="popular">

                        <div class="heading">
                            <span>popular food</span>
                            <h3>our special dishes</h3>
                        </div>

                        <div class="box-container">
                                
                                <?php 
                                    $db = new Database('127.0.0.1', '3306', 'root', 'Mario2022', 'aim2');
                                    if($db){
                                        $products = $db->fetchALl('product');
                                        foreach ($products as $index=>$product) {
//                                            var_dump($product);
                                            echo "
                                                <div class='box' onclick='addOrder($product[id])'>
                                                    <input class='prdId' name='prdId' type='hidden' value=$product[id] />
                                                    <a class='ri-heart-line wishlist-icon'></a>
                                                    <div class='image'>
                                                    <a style='cursor:pointer;'> 
                                                        <img class='w-100' style='height:150px;border-radius:10px'  src='../../public/images/products/$product[image]' alt='product$index'>
                                                    </a>
                                                    </div>
                                                    <div class='content'>
                                                        <h3 class='prdName'>$product[name]</h3>
                                                        <div class='stars'>
                                                            <i class='fas fa-star'></i>
                                                            <i class='fas fa-star'></i>
                                                            <i class='fas fa-star'></i>
                                                            <i class='fas fa-star'></i>
                                                            <i class='fas fa-star-half-alt'></i>
                                                            <span> (50) </span>
                                                        </div>
                                                        <div><span class='prdPrice'>$$product[price]</span> </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                    }
                                ?>
                        </div>
                    </section>
                </div>
            </div>

            <div class="col-4 d-flex align-items-center">
                <div>
                    <div class="order-checkout receipt">
                        <div class="row">
                            <div class="col-12">
                                <form action="">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Sub Total</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-table">

                                        </tbody>
                                        <tfoot>
                                            <tr class="cart_buttons">
                                                <td colspan="5">
                                                    <a class="btn btn-outline-warning py-3 px-4">Update cart</a>
                                                    <a class="btn btn-outline-danger py-3 px-4" id="cart_clear" onclick="deleteAllOrders()">Clear cart</a>
                                                </td>
                                            </tr>

                                            <tr class="cart_summary">
                                                <td colspan="5">
                                                    <p class="cart_summary__row" id="totalPrice">Total price <b class="total-price">$0.00</b></p>
                                                    <p class="cart_summary__instructions">
                                                        <label class="mb-2">Special instructions for seller</label>
                                                        <textarea class="form-control" name="note"></textarea>
                                                    </p>
                                                    <div class="cart_summary__checkout">
                                                        <div class="cart_summary__checkout__button_wrapper">
                                                            <button type="submit" name="checkout" class="btn btn-primary py-3 px-4">Proceed to checkout</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script src="../../public/js/script.js"></script>
    <script src="../../public/js/user_order.js"></script>
</body>
</html>