<?php 


echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">';
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../helpers/database.php');


echo "
<nav class='navbar navbar-expand-lg bg-body-tertiary'>
    <div class='container-fluid'>
        <div class='row w-100'>
            <div class='col-12'>
                <div class='d-flex align-items-center justify-content-between'>
                    <a aria-current='page' href='index.php'>
                        <div class='logo'>
                            <img src='../public/images/PHP-logo.svg.png' width='70' height='70'/>
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
    <link rel="stylesheet" href="../public/styles/user_order.css">
    <title>Order</title>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-12 my-3">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="row">

                    <?php 
                        $db = new Database('127.0.0.1','3306','mario','Mario123456789_','ai2m');
                        if($db){
                            $products = $db->fetchALl('product');
                            foreach ($products as $product) {
                                echo "
                                    <div class='col-3 my-3'>
                                        <div class='product'>
                                            <div>
                                                <a href='#'> <img class='w-100' style='height:150px;border-radius:10px' src='$product[image]' alt='product'></a>
                                            </div>
                                            <div>
                                                <h5>$product[name]</h5>
                                            </div>
                                            <div>
                                                <span>$$product[price].00</span>
                                            </div>
                                        </div>
                                    </div>
                                
                                ";
                            }
                        }
                    ?>
                </div>

            </div>
            <div class="col-4">
                <div class="receipt">
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
                                    <tbody>
                                        <tr>
                                            <td><span>tea</span></td>
                                            <td><span>tea</span></td>
                                            <td class="d-flex"><button class="btn btn-success">+</button><input class="form-control mx-1" type="number" style="width:30px;padding:0px;text-align:center;" name="quantity"/><button class="btn btn-danger">-</button></td>
                                            <td><span>20$</span></td>
                                            <td><i class="fa-solid fa-trash-can"></i></td>

                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="cart_buttons">
                                            <td colspan="5">
                                                <button class="btn btn-outline-warning">Update cart</button>
                                                <a class="btn btn-outline-danger" id="cart_clear" href="#">Clear cart</a>
                                                
                                                
                                            </td>
                                        </tr>

                                        <tr class="cart_summary">
                                            <td colspan="5">
                                                <p class="cart_summary__row">Total price <b class="total-price">$30.00</b></p>
                                                <p class="cart_summary__instructions">
                                                    <label class="mb-2">Special instructions for seller</label>
                                                    <textarea class="form-control" name="note"></textarea>
                                                </p>
                                                <div class="cart_summary__checkout">
                                                    <div class="cart_summary__checkout__button_wrapper">
                                                        <button type="submit" name="checkout" class="btn btn-primary">Proceed to checkout</button>
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

</body>
</html>