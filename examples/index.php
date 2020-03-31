<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/pics/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jquery-slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <title>
        Pagantis Order API Client Examples
    </title>
</head>
<body>
<?php
error_reporting(E_ALL);
require_once('utils/Helpers.php');
session_start();
setCurrentPageInSession();
?>
<div class="container">
    <div class="fixed-top">

        <?php
        if (!areKeysSet()) {
            echo showKeysMissingErrorMessage();
        } ?>
    </div>
    <?php include('views/navBar.php') ?>

    <div class="col-md-auto">
        <div class="row justify-content-center">
            <h5>Order API Client Examples</h5>
        </div>
    </div>


    <div class="col-md-auto">
        <b class="hr"></b>
        <form class="form-inline">
            <div class="mb-2 mr-md-4">
                <label for="getOrderID">Create an Order</label>
            </div>
            <div class="mb-2 mr-md-4">
                <input type="submit" value="submit" class="btn btn-primary" formmethod="get"
                       formaction="methods/createOrder.php">
            </div>
        </form>

        <b class="hr"></b>
        <form class="form-inline" action="methods/getOrder.php" method="POST">

            <div class="mb-2 mr-md-4">
                <label for="getOrderID">Get Order By ID</label>
            </div>
            <div class="mb-2 mr-md-4">
                <input type="text" class="form-control" name="getOrderID" id="getOrderID" placeholder="order ID"
                       required>
            </div>

            <div class="mb-2 mr-md-4">
                <input type="submit" value="submit" class="btn btn-primary">
            </div>

        </form>

        <b class="hr"></b>

        <form class="form-inline" action="methods/confirmOrder.php" method="POST">
            <div class="mb-2 mr-md-4">
                <label for="confirmOrder">Confirm all Authorized Orders</label>

            </div>

            <div class="mb-2 mr-md-4">
                <input type="submit" value="submit" class="btn btn-primary">

            </div>
        </form>


        <b class="hr"></b>
        <form class="form-inline" action="methods/listOrders.php" method="get">
            <div class="mb-2 mr-md-4">
                <label for="confirmOrder">List all Orders</label>

            </div>

            <div class="mb-2 mr-md-4">
                <input type="submit" value="submit" class="btn btn-primary">

            </div>
        </form>

        <b class="hr"></b>
        <div class="col-md-5">
            <form action="methods/refundOrder.php" method="POST">
                <div class="mb-2 mr-md-4">
                    <label for="refundOrderID">Refund Order By ID</label>
                </div>

                <div class="mb-2 mr-md-4">
                    <input type="text" name="refundOrderID" class="form-control" id="refundOrderID"
                           placeholder="Order ID" required></div>
                <div class="mb-2 mr-md-4">
                    <label for="refundOrderAmount">Refund Amount</label>
                    <input type="number" class="form-control" name="refundOrderAmount" id="refundOrderAmount"
                           placeholder="refund amounts in cents" required>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="submit" value="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
        <b class="hr"></b>
    </div>
</div>
<?php include('views/footer.php') ?>


</body>
</html>