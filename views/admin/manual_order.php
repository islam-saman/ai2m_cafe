<?php include("../../helpers/include_with_variable.php") ?>

<?php include_with_variable('head.php', array('title' => 'Manual Order', 'link' => '../../public/styles/table.css', 'fontawesome' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')); ?>

<body>

    <!-- header section starts  -->

    <?php include('header.php') ?>

    <!-- header section ends  -->

    <!-- main section starts -->

    <main>
        <div class="container mt-5 px-2">

            <h1 class="text-center mb-5" style="font-size: 3.7rem;">Orders</h1>
            <div class="mb-2 d-flex justify-content-between align-items-center">

            </div>
            <div class="table-responsive">
                <table class="table table-responsive table-borderless">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" width="5%">#</th>
                            <th scope="col" width="20%">Date</th>
                            <th scope="col" width="20%">Status</th>
                            <th scope="col" width="20%">Name</th>
                            <th scope="col" width="10%">Room</th>
                            <th scope="col" width="10%">Total Price</th>
                            <th scope="col" width="5%">Ext</th>
                            <th scope="col" class="text-end" width="10%">Action</th>
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
    <script src="../../public/js/admin/order.js"></script>
    <script>

    </script>

</body>