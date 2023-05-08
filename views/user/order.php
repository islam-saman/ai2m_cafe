<?php include("../../helpers/include_with_variable.php") ?>

<?php include_with_variable('head.php', array('title' => 'My Orders', 'link' => '../../public/styles/table.css', 'fontawesome' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')); ?>

<body onload="getAllOrders()">

<!-- header section starts  -->

<?php include('header.php') ?>

<!-- header section ends  -->

<!-- main section starts -->


<main>
    <div class="container mt-5 px-2">

        <h1 class="text-center mb-5" style="font-size: 3.7rem;">Orders</h1>
        <div class="mb-2 d-flex justify-content-between align-items-center">

        </div>
        <div class="d-flex justify-content-around mb-5 flex-wrap">
            <div>
                <label for="start">Start Date:</label>
                <input type="date" name="start" id="start" class="form-control" style="font-size: 2rem">
            </div>
            <div>
                <label for="end">End Date:</label>
                <input type="date" name="end" id="end" class="form-control" style="font-size: 2rem">
            </div>
            <button class="btn btn-success fs-2 mt-3" onclick="filterOrders()" style="height: 50px; width: 150px;">Filter</button>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive table-borderless">
                <thead>
                <tr class="bg-light">
                    <th scope="col" width="10%">#</th>
                    <th scope="col" width="20%">Date</th>
                    <th scope="col" width="20%">Status</th>
                    <th scope="col" width="20%">Name</th>
                    <th scope="col" width="10%">Room</th>
                    <th scope="col" width="8%">Total Price</th>
                    <th scope="col" width="5%">Ext</th>
                    <th scope="col" class="text-end">Action</th>
                </tr>
                </thead>
                <tbody id="orderData">

                </tbody>
            </table>

        </div>

    </div>
</main>

<!-- main section ends -->

<!-- footer section starts  -->

<?php include('footer.php') ?>

<!-- footer section ends  -->

<!-- custom js file link  -->
<script src="../../public/js/script.js"></script>
<script src="../../public/js/user/my_order/order.js"></script>

</body>