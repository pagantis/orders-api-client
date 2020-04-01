<?php
set_include_path(__DIR__);
require_once('utils/Helpers.php');
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<?php include ('views/sections/header.php')?>
    <title>
        Order API Client Examples
    </title>
</head>
<body>
<div class="container">
    <nav>
        <?php include 'views/sections/navBar.php' ?>
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

        <b class="hr"></b>

        <div class="container">
        <form class="form-inline">
            <div class="mb-2 mr-md-4">
            <label for="getOrderID">Create an Order</label>
            </div>
            <div class="mb-2 mr-md-4">
            <input type="submit" value="submit" class="btn btn-primary ml-2" formmethod="get"
                   formaction="methods/createOrder.php">
            </div>
        </form>
        <?php include('views/codeBlocks/createOrderBlock.php') ?>
        </div>

        <b class="hr"></b>
        <div class="container">
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
            <?php include('views/codeBlocks/getOrderBlock.php') ?>
        </div>

        <b class="hr"></b>
        <div class="container">

            <form class="form-inline" action="methods/confirmOrder.php" method="POST">

                <div class="mb-2 mr-md-4">
                    <label for="confirmOrder">Confirm all Authorized Orders</label>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="submit" value="submit" class="btn btn-primary">
                </div>

            </form>
            <?php include('views/codeBlocks/confirmOrdersBlock.php') ?>
        </div>
        <b class="hr"></b>
        <div class="container">

            <form class="form-inline" action="methods/listOrders.php" method="post">
                <div class="mb-2 mr-md-4">
                    <label for="orderStatusInput">List orders by status</label>
                </div>
                <div class="mb-2 mr-md-4">
                    <select class="form-control" id="orderStatusInput" name="orderStatusInput">
                        <option value="CONFIRMED">CONFIRMED</option>
                        <option value="INVALIDATED">INVALIDATED</option>
                    </select>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="submit" value="submit" class="btn btn-primary">
                </div>
            </form>
            <?php include('views/codeBlocks/listOrdersBlock.php') ?>
        </div>
        <b class="hr"></b>
        <div class="container">
            <form class="form-inline" action="methods/refundOrder.php" method="POST">
                <div class="mb-2 mr-md-4">
                    <label for="refundOrderID">Refund Order By ID</label>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="text" name="refundOrderID" class="form-control" id="refundOrderID"
                           placeholder="Order ID" required>
                </div>
                <div class="mb-2 mr-md-4">
                    <label for="refundOrderAmount">Refund Amount</label>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="number" class="form-control" name="refundOrderAmount" id="refundOrderAmount"
                           placeholder="refund amounts in cents" required>
                </div>
                <div class="mb-2 mr-md-4">
                    <input type="submit" value="submit" class="btn btn-primary">
                </div>

            </form>
            <?php include('views/codeBlocks/refundOrderBlock.php') ?>
        </div>
    </indexForms>
    <footer>
        <?php include('views/sections/footer.php') ?>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.19.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.19.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.19.0/plugins/line-highlight/prism-line-highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.19.0/plugins/autoloader/prism-autoloader.min.js"></script>
</body>
</html>
