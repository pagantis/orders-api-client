<div class="container-fluid">
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                            aria-controls="collapseThree">
                        Code Example
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                    <section class="line-numbers"><pre class="language-php"><code>
$publicKey = env('PAGANTIS_PUBLIC_KEY');
$privateKey = env('PAGANTIS_PRIVATE_KEY');

$orderApiClient = new \Pagantis\OrdersApiClient\Client($publicKey, $privateKey);

$authorizedOrders = $orderApiClient->listOrders([
                                'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED
                                ]);
$confirmedOrders = [];
foreach ($authorizedOrders as $order) {
    $confirmedOrder = $orderApiClient->confirmOrder($order->getId());
    $confirmedOrders[] = $confirmedOrder;
    }
                    </code></pre>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <button class="btn-link p-0 border-0" type="button">
            <i class="fas fa-link"></i>
            <a href="https://developer.pagantis.com/index.html#confirm-order" target="_blank">Documentation</a>
        </button>
    </footer>
</div>

