<div class="container">
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                            aria-controls="collapseTwo">
                        Code Example
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <section class="line-numbers" style="white-space:pre-wrap;"><pre class="language-php"><code>
$publicKey = env('PAGANTIS_PUBLIC_KEY');
$privateKey = env('PAGANTIS_PRIVATE_KEY');

$orderApiClient = new \Pagantis\OrdersApiClient\Client($publicKey, $privateKey);

$order = $orderApiClient->getOrder($orderID, $asJson = true);
                            </code></pre>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer"><a href="https://developer.pagantis.com/index.html#get-order" target="_blank">for more
            information see </a></footer>
</div>

