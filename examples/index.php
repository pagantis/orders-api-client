<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Pagantis Order API Client Examples</title>
    <?php
    require_once('../examples/utils/Helpers.php');
    writeLog('Session Started', jsonEncoded(basename(__FILE__)), true);
    session_start();
    ?>
</head>
<body>
<header class="main">
    <div style="text-align: center;"><h3>Pagantis Order API Client Examples</h3></div>
</header>
<section class="main">
    <div>
        <h4>Create an Order</h4>
        <p>
            <button><a href="createOrder.php">Create an Order</a></button>
        </p>
    </div>

    <hr>

    <div>
        <h4>Get Order By ID</h4>
        <form action="getOrder.php" method="POST">
            <p><input type="text" name="getOrderID" id="getOrderID" placeholder="order ID"><input
                        type="submit" value="get order"></p>
        </form>
    </div>

    <hr>

    <div>
        <h4>Confirm all authorized orders</h4>
        <p>
            <button><a href="confirmOrder.php" target="_blank">Confirm all authorized orders</a>
            </button>
        </p>
    </div>

    <hr>

    <div>
        <h4>List all Confirmed Orders</h4>

        <p>
            <button><a href="listOrders.php" target="_blank">List all Confirmed Orders</a>
            </button>
        </p>
    </div>
    <hr>
    <div>
        <h4>Refund Order By ID</h4>
        <form action="refundOrder.php" method="POST">
            <p><input type="text" name="refundOrderID" id="refundOrderID" placeholder="order ID"
                      required><input type="text" name="refundOrderAmount" id="refundOrderAmount"
                                      placeholder="Refund Amount " required><input
                        type="submit" value="confirm order"></p>
        </form>
    </div>
</section>
</body>
</html>