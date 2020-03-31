<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/pics/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/solid.min.css" type="text/css">
    <script src="assets/js/script.js"></script>
    <title>
        Pagantis Order API Client Examples
    </title>
</head>
<body>
<?php
error_reporting(E_ALL);
require_once('utils/Helpers.php');
session_start();
?>
<div class="container">
    <nav>
        <?php include('views/navBar.php') ?>

        <div class="col-md-auto">
            <div class="row justify-content-center">
                <h5>Order API Client Examples</h5>
            </div>
        </div>
    </nav>
    <createAlerts>
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                         onclick="<?php session_destroy();
                         session_regenerate_id(); ?>">
                        <h4 class="alert-heading"><?php echo $_SESSION['success_message'] ?></h4>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php elseif (isset($_SESSION['failure_message'])): ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                         onclick="<?php session_destroy();
                         session_regenerate_id(); ?>">
                        <?php echo $_SESSION['failure_message'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-auto">
                <?php if (isset($_SESSION['order_not_found_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                         onclick="<?php session_destroy();
                         session_regenerate_id(); ?>">
                        <h4 class="alert-heading"><?php echo $_SESSION['order_not_found_message'] ?></h4>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>


    </createAlerts>
    <indexForms>

        <div class="col-md-auto">
            <b class="hr"></b>
            <form class="form-inline">
                <div class="mb-2 mr-md-4">
                    <label for="getOrderID">Create an Order</label>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="submit" value="submit" class="btn btn-primary" formmethod="get"
                           formaction="methods/createOrder.php">
                </div>
            </form>

            <b class="hr"></b>
            <form class="form-inline" action="methods/getOrder.php" method="POST">

                <div class="mb-2 mr-md-4">
                    <label for="getOrderID">Get Order By ID</label>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="text" class="form-control" name="getOrderID" id="getOrderID" placeholder="order ID"
                           required>
                </div>

                <div class="mb-2 mr-md-4">
                    <input type="submit" value="submit" class="btn btn-primary">
                </div>

            </form>

            <b class="hr"></b>

            <form class="form-inline" action="methods/confirmOrder.php" method="POST">
                <div class="mb-2 mr-md-4">
                    <label for="confirmOrder">Confirm all Authorized Orders</label>

                </div>

                <div class="mb-2 mr-md-4">
                    <input type="submit" value="submit" class="btn btn-primary">

                </div>
            </form>


            <b class="hr"></b>
            <form action="methods/listOrders.php" method="post">
                <div class="form-group">
                    <label for="orderStatusInput">select an order status</label>
                    <select class="form-control" id="orderStatusInput" name="orderStatusInput">
                        <option value="CONFIRMED">CONFIRMED</option>
                        <option value="INVALIDATED">INVALIDATED</option>
                    </select>
                </div>
                <div class="mb-2 mr-md-5">
                    <input type="submit" value="submit" class="btn btn-primary">
                </div>
            </form>
            <b class="hr"></b>
            <div class="col-md-5">
                <form action="methods/refundOrder.php" method="POST">
                    <div class="mb-2 mr-md-4">
                        <label for="refundOrderID">Refund Order By ID</label>
                    </div>

                    <div class="mb-2 mr-md-4">
                        <input type="text" name="refundOrderID" class="form-control" id="refundOrderID"
                               placeholder="Order ID" required></div>
                    <div class="mb-2 mr-md-4">
                        <label for="refundOrderAmount">Refund Amount</label>
                        <input type="number" class="form-control" name="refundOrderAmount" id="refundOrderAmount"
                               placeholder="refund amounts in cents" required>
                    </div>
                    <div class="mb-2 mr-md-4">
                        <input type="submit" value="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <b class="hr"></b>
    </indexForms>
    <footer>
        <?php include('views/footer.php') ?>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"> </script>
</body>
</html>
