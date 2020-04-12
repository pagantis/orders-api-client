<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include(__DIR__ . '/sections/header.php') ?>
    <title> Get Order by ID</title>
</head>
<body>

<results>
    <div class="container">
        <nav class="mb-3">
            <div class="fixed-top">
                <?php
                if (!areKeysSet()) {
                    echo showKeysMissingErrorMessage();
                } ?>
            </div>
            <?php include(__DIR__ . '/sections/navBar.php') ?>

            <div class="col-md-auto">
                <div class="row justify-content-center">
                    <h5>Get Order by ID Example</h5>
                </div>
            </div>
        </nav>
        <results>
            <div class="col-md-auto justify-content-center">
                <?php
                try {
                    $orderID = $_POST['getOrderID'];
                    $orderApiClient = getOrderApiClient();
                    $order = $orderApiClient->getOrder($orderID, $asJson = true);
                    $orderArray = json_decode($order, true);

                    print ('<div class="d-flex p-2 bd-highlight">' . $order . '</div>');
                } catch (Exception $e) {
                    $e->getMessage();
                }

                ?>

                <?php if ($orderArray >= 1) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo ' 1 order found.' ?>
                </div>
            </div>
                    <?php
                    try {
                        $orderApiClient = getOrderApiClient();
                        $order = $orderApiClient->getOrder($orderID, $asJson = true);
                    } catch (\Exception $e) {
                        $e->getMessage();
                    }
                    ?>
                    <?php $orderArr = json_decode($order, true); ?>
            <div class="container">
                <div class="card bg-light">
                    <div class="card-header">Order : <?php echo $orderArr['id'] ?></div>
                    <div class="card-body">
                        <p class="card-text"> Order status : <?php echo $orderArr['status'] ?> </p>
                        <p class="card-text"> Order created at : <?php echo $orderArr['created_at'] ?></p>
                        <p class="card-text"> Order expires(d) at : <?php echo $orderArr['expires_at'] ?></p>
                    </div>
                </div>
            </div>

                <?php elseif ($orderID < 1) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo 'Order ' . $orderID . ' not found.' ?></div>';
                <?php endif; ?>
    </div>
</results>

<?php include(__DIR__ . '/sections/footer.php') ?>

</body>
</html>
