<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include (__DIR__.'/sections/header.php')?>
    <title> Refund Order ID</title>
</head>
<body>
<div class="container">
    <nav class="mb-3">
        <div class="fixed-top">

            <?php
            if (!areKeysSet()) {
                echo showKeysMissingErrorMessage();
            } ?>
        </div>
        <?php include(__DIR__.'/sections/navBar.php') ?>

        <div class="col-md-auto">
            <div class="row justify-content-center">
                <h5>Refund Order Example</h5>
            </div>
        </div>
    </nav>
    <results>
        <div class="col-md-auto justify-content-center">
            <?php
            try {
                $refundOrderID = $_POST['refundOrderID'];
                $refundOrderAmount = $_POST['refundOrderAmount'];
                $orderApiClient = getOrderApiClient();
                $refund = new \Pagantis\OrdersApiClient\Model\Order\Refund();
                $refund->setPromotedAmount(0)
                       ->setTotalAmount($refundOrderAmount);
                $refundCreated = $orderApiClient->refundOrder($refundOrderID, $refund);
            } catch (Exception $e) {
                $e->getMessage();
            }
            ?>
            <div class="alert alert-success" role="alert">
                <?php echo ' 1 order refunded.' ?>
            </div>
            <?php
            try {
                $orderApiClient = getOrderApiClient();
                $order = $orderApiClient->getOrder($refundOrderID, $asJson = true);
            } catch (\Exception $e) {
                $e->getMessage();
            }
            ?>
            <?php $refundedOrderArray = json_decode($order, true); ?>
            <div class="card bg-light">
                <div class="card-header">Order : <?php echo $refundedOrderArray['id'] ?></div>
                <div class="card-body">
                    <p class="card-text"> Refund amount : <?php echo $refundedOrderArray['status'] ?> </p>
                    <?php $refunds = $refundedOrderArray['refunds']; ?>
                        <?php foreach ($refunds as $refund) : ?>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Refund amount : <?php echo $refund['total_amount'] ?> </li>
                                <li class="list-group-item">Refund created at : <?php echo $refund['created_at'] ?> </li>
                        <?php endforeach; ?>
                </div>
            </div>
            <?php if (isset($_SESSION['order_not_found_message'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['order_not_found_message'] ?></div>';
            <?php endif; ?>
    </results>

        <?php include(__DIR__.'/sections/footer.php') ?>

</div>
</body>
</html>