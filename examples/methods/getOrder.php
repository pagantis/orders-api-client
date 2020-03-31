<?php
//Require the Client library using composer: composer require pagantis/orders-api-client
require_once('../../vendor/autoload.php');

/**
 * Require the helper functions
 * ⚠⚠⚠
 * PLEASE SET YOUR PUBLIC KEY AND PRIVATE KEY
 * IN examples/utils/Helpers.php
 * ⚠⚠⚠
 */
require_once('../utils/Helpers.php');
error_reporting(E_ALL);
session_start();

if (!isset($_POST['getOrderID'])) {
    throw new \Exception('You need to input the Order ID');
}
try {
    $logsFileName = basename(__FILE__);
    $logsWithDate = true;

    $orderApiClient = getOrderApiClient();
    writeLog('Client Created', $logsFileName, $logsWithDate);

    $orderID = $_POST['getOrderID'];
    writeLog('Fetching Order with ID: ' . jsonEncoded($orderID), $logsFileName, $logsWithDate);

    $order = $orderApiClient->getOrder($orderID, $asJson = true);
    writeLog('Order with ID ' . jsonEncoded($orderID) . 'found', $logsFileName, $logsWithDate);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

function showSuccessMessage($order)
{
    $successMessage = "<div class=\"card text-white bg-success mb-3   h-100 justify-content-center \" style=\"max-width: 30rem;\">
  <div class=\"card-header\">Order $order->id Found</div>
  <div class=\"card-body\">
         <p class=\"card-text\"> Order status: $order->status </p>
         <p class=\"card-text\"> Order created at:  $order->created_at </p>
         <p class=\"card-text\"> Order confirmed at: $order->confirmed_at </p>
  </div>
  </div>";
    return $successMessage;
}


?>
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
    <title> Get Order by ID</title>
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
        <?php include('../views/navBar.php') ?>

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
        <div class="card bg-light">
            <div class="card-header">Order : <?php echo $orderArr['id'] ?></div>
            <div class="card-body">
                <p class="card-text"> Order status : <?php echo $orderArr['status'] ?> </p>
                <p class="card-text"> Order created at : <?php echo $orderArr['created_at'] ?></p>
                <p class="card-text"> Order expires(d) at : <?php echo $orderArr['expires_at'] ?></p>
            </div>
        </div>
            <?php elseif ($orderID < 1) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo 'Order ' . $orderID . ' not found.' ?></div>';
            <?php endif; ?>
</div>
</results>
<?php include('../views/footer.php') ?>

</body>
</html>