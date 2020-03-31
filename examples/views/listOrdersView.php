<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../assets/pics/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/styles.css" type="text/css">
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/jquery-slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <title> List orders by Status</title>
</head>
<body>
<div class="container">
    <nav>
        <div class="fixed-top">
            <?php
            if (!areKeysSet()) {
                echo showKeysMissingErrorMessage();
            } ?>
        </div>
        <?php include('../views/navBar.php') ?>
        <div class="col-md-auto">
            <div class="row justify-content-center">
                <h5>List Orders Example</h5>
            </div>
        </div>
    </nav>
    <ordersList>
        <?php
        try {
            $orderApiClient = getOrderApiClient();
            $orderStatus = $_POST['orderStatusInput'];
            $queryString = array('channel' => 'ONLINE', 'pageSize' => 20, 'page' => 1, 'status' => $orderStatus);
        $orders = $orderApiClient->listOrders($queryString, $asJson = true);
        } catch (\Exception $e) {
        $e->getMessage();
        }
        ?>
        <?php $ordersArray = json_decode($orders, true); ?>

        <?php if ($ordersArray >= 1) : ?>
        <div class="col-md-auto">
            <div class="row"></div>
            <div class="alert alert-success" role="alert">
                <?php echo count($ordersArray) . ' orders with status ' . $orderStatus . ' found'; ?>
            </div>
        </div>
        <div class="container">
            <div class="row-fluid">
                <?php foreach ($ordersArray as $order) : ?>
                <div class="card-columns-fluid">
                    <div class="col-md-auto">
                        <div class="card bg-light mt-2 mb-2">
                            <div class="card-body">
                                <p class="card-title"> Order ID: <?php echo $id = $order['id']; ?></p>
                                <p class="card-text"> Order Status : <?php echo $status = $order['status']; ?> </p>
                                <p class="card-text"> Shop Order
                                    Reference: <?php echo $shopOrderID = $order['shopping_cart']['order_reference']; ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </ordersList>
    <?php elseif ($orderArray < 1) : ?>
    <alertBoxes>
        <div class="container-fluid align-content-center">
            <!--First row-->
            <div class="row align-content-center">
                <!--First column-->
                <div class="col-lg-auto mb-4">
                    <div class="alert alert-info"
                         role="alert">  <?php echo count($ordersArray) . 'orders with status ' . $orderStatus . ' found'; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
    </alertBoxes>

        <?php include('../views/footer.php') ?>

</div>
</body>
</html>