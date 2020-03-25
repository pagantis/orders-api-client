<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Pagantis Order API Client Examples</title>
</head>
<body>
<header class="main">
    <div style="text-align: center;"><h3>Pagantis Order API Client Examples</h3></div>
</header>
<section class="warn">
    <?php require_once('utils/Helpers.php'); ?>
    <?php  if (!areKeysSet()) {
        print("<legend>" . "Please set the public and private key in examples/utils/Helpers.php" . "</legend>");
        echo '<script type="text/javascript">  
        window.alert("Please set the public and private key in examples/utils/Helpers.php")
     </script>';
    }?>
</section>
<section class="main">
    <div>
        <h4>Create an Order</h4>
        <p>
            <button><a href="methods/createOrder.php">Create an Order</a></button>
        </p>
    </div>

    <hr>

    <div>
        <h4>Get Order By ID</h4>
        <form action="methods/getOrder.php" method="POST">
            <p><input type="text" name="getOrderID" id="getOrderID" placeholder="order ID" required><input
                        type="submit" value="get order"></p>
        </form>
    </div>

    <hr>

    <div>
        <h4>Confirm all Authorized Orders</h4>
        <p>
            <button><a href="methods/confirmOrder.php" target="_blank">Confirm all authorized orders</a>
            </button>
        </p>
    </div>

    <hr>

    <div>
        <h4>List all Confirmed Orders</h4>

        <p>
            <button><a href="methods/listOrders.php" target="_blank">List all Confirmed Orders</a>
            </button>
        </p>
    </div>
    <hr>
    <div>
        <h4>Refund Order By ID</h4>
        <form action="methods/refundOrder.php" method="POST">
            <p><input type="text" name="refundOrderID" id="refundOrderID" placeholder="Order ID"
                      required><input type="number" name="refundOrderAmount" id="refundOrderAmount"
                                      placeholder="Refund Amount" required><input
                        type="submit" value="refund order"></p>
        </form>
    </div>
</section>
</body>
</html>