
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
    <title>Confirm Orders</title>
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
                <h5>Confirm Order Example</h5>
            </div>
        </div>
    </nav>
    <orderCards>
        <div class="container">
            <div class="row-fluid ">
                <?php
                try {
                    $logsWithDate = true;
                    $logsFileName = basename(__FILE__);
                    $orderApiClient = getOrderApiClient();
                    $confirmedOrders = getConfirmedOrders($orderApiClient, $asJson = true);
                } catch (\Exception $e) {
                    $e->getMessage();
                }
                $confirmedOrdersArray = json_decode($confirmedOrders, true);
                ?>


                <?php if ($confirmedOrdersArray >= 1) : ?>
                <div class="col-md-auto">
                    <div class="row"></div>
                    <div class="alert alert-success" role="alert">
                        <?php echo count($confirmedOrdersArray) . ' Confirmed orders found' ?>
                    </div>
                </div>
                <div class="card-columns-fluid">
                    <div class="card bg-light mt-2 mb-2">
                        <?php foreach ($confirmedOrdersArray as $order) : ?>
                        <div class="card-body">
                            <p class="card-title"> Order ID: <?php echo $id = $order['id']; ?></p>
                            <p class="card-text"> Order Status : <?php echo $status = $order['status']; ?> </p>
                            <p class="card-text"> Shop Order
                                Reference: <?php echo $shopOrderID = $order['shopping_cart']['order_reference']; ?> </p>
                        </div>
                    </div>
                        <?php endforeach; ?>
                </div>
            </div>
        </div>
    </orderCards>

                <?php else : ?>
                    <?php
                    try {
                        $orderApiClient = getOrderApiClient();
                        $createdOrders = getCreatedOrders($orderApiClient, $asJson = true);
                        $invalidatedOrders = getInvalidatedOrders($orderApiClient, $asJson = true);
                    } catch (\Exception $e) {
                        $e->getMessage();
                    }
                    ?>

                    <?php $createdOrdersArray = json_decode($createdOrders, true); ?>
                    <?php $invalidatedOrdersArray = json_decode($invalidatedOrders, true); ?>
    <alertBoxes>
        <div class="container-fluid align-content-center">
            <div class="row align-content-center">

                <div class="col-lg-auto mb-4">
                    <div class="alert alert-info"
                         role="alert">  <?php echo count($invalidatedOrdersArray) . ' Invalidated Orders Found' ?></div>
                </div>

                <div class="col-lg-auto mb-4">
                    <div class="alert alert-info"
                         role="alert">  <?php echo count($confirmedOrdersArray) . ' Confirmed Orders Found' ?>
                    </div>
                </div>
            </div>
                <?php endif; ?>
        </div>
    </alertBoxes>

        <?php include('footer.php') ?>

</div>
</body>
</html>