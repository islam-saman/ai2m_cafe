<?php include("../../helpers/include_with_variable.php") ?>


<?php include_with_variable('head.php', array('title' => 'Home' , 'link'=>'../../public/styles/table.css')); ?>

<body>
<?php include ("./header.php") ?>

<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-2">
            <div class=" box-container row" id="last-product"></div>
        </div>
        <div class="product-container col-md-8  justify-content-center">
            <div class="col-6 search-bar rounded-4 mt-5 mb-5">
                <form class="d-flex " role="search">
                    <input class="form-control px-3 py-4 me-2" type="search" id="searchInput" placeholder="Search" aria-label="Search">
                    <button class="search-button">
                        <i class="fa-solid fa-magnifying-glass " onclick="filterProducts(event)"></i>
                    </button>
                    <!-- <button class="btn btn-outline-success px-5" onclick="filterProducts(event)" type="submit">Search</button> -->
                </form>
            </div>            
            <div class="box-container row" id="prd-box"></div>
        </div>
        <div class="col-12 col-md-2">
            <div>
                <div class="order-checkout receipt">
                    <div class="row">
                        <form method="POST" id="submit_order" class="row">
                                <div>
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
                                                    <label class="mb-2">Special instructions for seller</label>
                                                    <textarea class="form-control" id="user_comment" name="note"></textarea>
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
                                    
                                </div>
                                <div class="cart_summary__checkout__button_wrapper d-flex align-items-center justify-content-between">
                                    <div class="cart_buttons">
                                        <a class="btn btn-outline-danger py-3 px-4" id="cart_clear" onclick="deleteAllOrders()">Clear cart</a>
                                    </div>
                                    <div>
                                        <div>
                                            <input type="submit" name="checkout" class="btn  btn-outline-primary btn-procced py-3 px-4"
                                                    onclick="order()" value="Proceed"  />
                                        </div>
                                    </div>

                                </div>
                                <p style="display: none" id="submit_order_btn" class="text-danger">No products chosen</p>

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="../../public/js/user_order.js"></script>

</body>
