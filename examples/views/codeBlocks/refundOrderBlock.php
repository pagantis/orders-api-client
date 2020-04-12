<div class="container">
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingFive">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
                            aria-controls="collapseFive">
                        Code Example
                    </button>
                </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                <div class="card-body">
                    <section class="line-numbers"><pre class="language-php"><code>
$publicKey = env('PAGANTIS_PUBLIC_KEY');
$privateKey = env('PAGANTIS_PRIVATE_KEY');

$orderApiClient = new \Pagantis\OrdersApiClient\Client($publicKey, $privateKey);

$refund = new Pagantis\OrdersApiClient\Model\Order\Refund();
$refund->setPromotedAmount(0)->setTotalAmount(10);

$refundCreated = $apiClient->refundOrder($orderId, $refund);
                    </code></pre>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <button class="btn-link p-0 border-0" type="button">
            <i class="fas fa-link"></i>
            <a href="https://developer.pagantis.com/index.html#refund-order" target="_blank">Docs</a>
        </button>
    </footer>
</div>

