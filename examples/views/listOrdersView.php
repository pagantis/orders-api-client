<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include(__DIR__.'/sections/header.php')?>
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
        <?php include(__DIR__.'/sections/navBar.php') ?>
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

        <?php include(__DIR__.'/sections/footer.php') ?>

</div>
</body>
</html>