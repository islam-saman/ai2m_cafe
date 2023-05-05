<?php 


//echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">';
//echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include("../../helpers/include_with_variable.php");
include ("./head.php");
include('../../helpers/database.php');
include ('../../env.php');
//?>

<?php include_with_variable('head.php', array('title' => 'Home', 'link' => '../../public/styles/user_order.css', 'fontawesome' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css')); ?>

<body>
<?php include ("./header.php") ?>
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
            <div class="col-12 col-md-8">
                <div class="row">
                    <section class="popular" id="popular">

                        <div class="heading">
                            <span>popular food</span>
                            <h3>our special dishes</h3>
                        </div>

                        <div class="box-container" id="prd-box">
                        </div>
                    </section>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-center">
                <div>
                    <div class="order-checkout receipt">
                        <div class="row">
                            <div class="col-12">
                                <form method="POST" id="submit_order">
                                    <table class="table table-responsive">
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

                                            <tr class="cart_summary">
                                                <td colspan="5">
                                                    <p class="cart_summary__row" >Total price <b id="totalPrice" class="total-price">$0.00</b></p>
                                                    <p class="cart_summary__instructions">
                                                        <textarea placeholder="Special instructions for seller" class="form-control" id="user_comment" name="note"></textarea>
                                                    </p>
                                                    <div class="cart_summary__checkout">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div class="room_number mb-5">
                                        <div style="width: 100%" class="d-flex align-items-center justify-content-between">
                                            <input class="form-control w-100" style="width: 100%" type="number" id="room_number" placeholder="Room Number"/>
                                            <input class="form-control w-100" type="number" id="ext" placeholder="Ext" />
                                        </div>
                                    </div>

                                    <div class="cart_summary__checkout__button_wrapper d-flex align-items-center justify-content-between">
                                        <div class="cart_buttons">
                                             <a class="btn btn-outline-danger py-3 px-4" id="cart_clear" onclick="deleteAllOrders()">Clear cart</a>
                                        </div>
                                        <div>
                                            <div>
                                                <input type="submit" name="checkout" class="btn btn-primary py-3 px-4"
                                                        onclick="order()" value="Proceed to checkout"  />
                                            </div>
                                                <p style="display: none" id="submit_order_btn" class="text-danger">No products chosen</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../public/js/user_order.js"></script>
</body>