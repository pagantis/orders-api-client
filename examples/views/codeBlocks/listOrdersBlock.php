<div class="container">
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingFour">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                            aria-controls="collapseFour">
                        Code Example
                    </button>
                </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                <div class="card-body">
                    <section class="line-numbers"><pre class="language-php"><code>
$queryString = ['channel' => 'ONLINE',
                'pageSize' => 20,
                'page' => 1,
                'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED
                ];

    try {
    $publicKey = env('PAGANTIS_PUBLIC_KEY');
    $privateKey = env('PAGANTIS_PRIVATE_KEY');

    $orderApiClient = new \Pagantis\OrdersApiClient\Client($publicKey, $privateKey);
        $confirmedOrders = $orderApiClient->listOrders($queryString);

        if (count($confirmedOrders) >= 1) {
            // Manage no result found
        }
    } catch (\Exception $exception) {
        $exception->getMessage();
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
            <a href="https://developer.pagantis.com/index.html#list-orders" target="_blank">Docs</a>
        </button>
    </footer>
</div>

