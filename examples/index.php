<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/pics/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    <script src="assets/js/script.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <title>Pagantis Order API Client Examples</title>
</head>
<body>
<?php
error_reporting(E_ALL);
require_once('utils/Helpers.php');
session_start();
setCurrentPageInSession();
?>


<div class="parent">
    <div class="hero">
        <img src="assets/pics/Pagantis_Logo_RGB.svg" alt="Pagantis logo">
        <div>
            <h4>Order API Client Examples</h4>
        </div>
        <?php
        if (!areKeysSet()) {
            $keysNotSetErrorMessage = '<div class="warning-msg" id="warningBox" onclick="setDisplayNone()">  <i class="fas fa-exclamation-triangle"></i> Please set the public and private key in examples/utils/Helpers.php <span class="closeButton"><i class="fas fa-window-close"></i></span></div>';
            echo $keysNotSetErrorMessage;
        } ?>
    </div>

    <div class="main">
        <div class="formgrid">
            <b class="hr"></b>

            <form class="form-inline">
                <label for="getOrderID">Create an Order</label>
                <input type="submit" value="submit" class="button" formmethod="get"
                       formaction="methods/createOrder.php">
        </div>
        <b class="hr"></b>

        <form action="methods/getOrder.php" method="POST" class="form-inline">
            <label for="getOrderID">Get Order By ID</label>
            <input type="text" name="getOrderID" id="getOrderID" placeholder="order ID" required>
            <input type="submit" value="get order" class="button">
        </form>

        <b class="hr"></b>


        <form action="methods/confirmOrder.php" method="POST" class="form-inline">
            <label for="confirmOrder">Confirm all Authorized Orders</label>
            <input type="submit" value="submit" class="btn btn-primary">
        </form>

        <b class="hr"></b>

        <form action="methods/listOrders.php" method="get" class="form-inline">
            <label for="confirmOrder">List all Orders</label>
            <input type="submit" value="submit" class="btn btn-primary">
        </form>

        <b class="hr"></b>

        <form action="methods/refundOrder.php" method="POST">

                <div class="col">
                    <div class="row">
                        <div class="col">

                        <h4>Refund Order By ID</h4>
                    </div>
                    <div class="row">
                            <input type="text" name="refundOrderID" class="form-control" id="refundOrderID" placeholder="Order ID" required></div>
                    </div>
                    <div class="row">
                        <div class="col">

                        <label for="refundOrderAmount">Refund Quantity</label>
                    </div>
                    <div class="row">
                        <input type="number" class="form-control" name="refundOrderAmount" id="refundOrderAmount"
                               placeholder="refund amounts in cents" required>
                    </div>
                    </div>
                    <div class="row">
                        <input type="submit" value="submit" class="button">
                    </div>
                </div>
        </form>
    </div>
</div>
<!--    <div class="footer">-->
<!--        <p>-->
<!--            "Pagantis" is a brand owned by the entity Pagantis, S.A.U. dedicated to the provision of payment services.-->
<!--            Pagantis, S.A.U. authorizes the use of its brand to the entity Pagamastarde, S.L.U., who makes use of it in-->
<!--            the provision of its consumer finance services.-->
<!--        </p>-->
<!--    </div>-->
</div>
</body>
</html>