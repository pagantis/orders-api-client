<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" href="assets/pics/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles.css" type="text/css">
    <title>Pagantis Order API Client Examples</title>
</head>
<body>
<?php
require_once('utils/Helpers.php');
session_start();
setCurrentPageInSession();
?>


<div class="parent">


    <div class="hero">

        <img src="assets/pics/Pagantis_Logo_RGB.svg" alt="Pagantis logo">
        <h4>Order API Client Examples</h4>
        <?php if (!areKeysSet()) {
            print("<legend>" . "Please set the public and private key in examples/utils/Helpers.php" . "</legend>");
            echo '<script type="text/javascript">  
        window.alert("Please set the public and private key in examples/utils/Helpers.php")
     </script>';
        } ?>
    </div>

    <div class="main">
        <fieldset>
            <div class="formgrid">
                <b class="hr"></b>

                <form class="form-inline">
                    <label for="getOrderID">Create an Order</label>

                    <input type="submit" value="submit" class="button" formmethod="get"
                           formaction="methods/createOrder.php">
                </form>
                <b class="hr"></b>

                <form action="methods/getOrder.php" method="POST" class="form-inline">
                    <label for="getOrderID">Get Order By ID</label>
                    <input type="text" name="getOrderID" id="getOrderID" placeholder="order ID" required>
                    <input type="submit" value="get order" class="button">
                </form>

                <b class="hr"></b>


                <form action="methods/confirmOrder.php" method="POST" class="form-inline">
                    <label for="confirmOrder">Confirm all Authorized Orders</label>
                    <input type="submit" value="submit" class="button">
                </form>

                <b class="hr"></b>

                <form action="methods/listOrders.php" method="get" class="form-inline">
                    <label for="confirmOrder">List all Orders</label>
                    <input type="submit" value="submit" class="button">
                </form>

                <b class="hr"></b>
                <h4>Refund Order By ID</h4>
                <form action="methods/refundOrder.php" method="POST" >
                    <label for="refundOrderID">Refund Order ID</label>
                    <input type="text" name="refundOrderID" id="refundOrderID" placeholder="Order ID" required>

                    <label for="refundOrderAmount">Refund Quantity</label>
                        <input type="number" name="refundOrderAmount" id="refundOrderAmount"
                               placeholder="refund amounts in cents" required>
                    <p><input type="submit" value="submit" class="button"></p>
                </form>
            </div>
        </fieldset>
    </div>
    <div class="footer">
        <p>
            "Pagantis" is a brand owned by the entity Pagantis, S.A.U. dedicated to the provision of payment services.
            Pagantis, S.A.U. authorizes the use of its brand to the entity Pagamastarde, S.L.U., who makes use of it in
            the provision of its consumer finance services.
        </p>
    </div>
</div>
</body>
</html>