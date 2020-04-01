<div class="container-fluid">
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                        Code Example
                    </button>
                </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <section class="line-numbers"><pre class="language-php"><code>
// There are  3 mandatory objects: User object, ShoppingCart object and Configuration object.
//1. User Object

$userAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();
$userAddress->setZipCode('28031')
            ->setFullName('María Sanchez Escudero')
            ->setCountryCode('ES')
            ->setCity('Madrid')
            ->setAddress('Paseo de la Castellana, 95')
            ->setDni('59661738Z')
            ->setNationalId('59661738Z')
            ->setFixPhone('911231234')
            ->setMobilePhone('600123123');

$orderBillingAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();
$orderBillingAddress->setZipCode('28031')
                    ->setFullName('María Sanchez Escudero')
                    ->setCountryCode('ES')
                    ->setCity('Madrid')
                    ->setAddress('Paseo de la Castellana, 95')
                    ->setDni('59661738Z')
                    ->setNationalId('59661738Z')
                    ->setFixPhone('911231234')
                    ->setMobilePhone('600123123');

$orderShippingAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();

$orderShippingAddress->setZipCode('08029')
                    ->setFullName('Alberto Escudero Sanchez')
                    ->setCountryCode('ES')
                    ->setCity('Barcelona')
                    ->setAddress('Avenida de la diagonal 525')
                    ->setDni('77695544A')
                    ->setNationalId('59661738Z')
                    ->setFixPhone('931232345')
                    ->setMobilePhone('600123124');

$orderUser = new \Pagantis\OrdersApiClient\Model\Order\User();
$orderUser->setFullName('María Sanchez Escudero')
          ->setAddress($userAddress)
          ->setBillingAddress($orderBillingAddress)
          ->setShippingAddress($orderShippingAddress)
          ->setDateOfBirth('1985-12-30')
          ->setEmail('user@my-shop.com')
          ->setFixPhone('911231234')
          ->setMobilePhone('600123123')
          ->setDni('59661738Z')
          ->setNationalId('59661738Z');
//2. ShoppingCart Object

$orderHistory = new \Pagantis\OrdersApiClient\Model\Order\User\OrderHistory();
$orderHistory->setAmount('2499')
             ->setDate('2010-01-31');

$orderUser->addOrderHistory($orderHistory);


$product = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details\Product();
$product->setAmount('59999')
        ->setQuantity('1')
        ->setDescription('TV LG UltraPlasma');

$details = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details();
$details->setShippingCost('0');
$details->addProduct($product);

$orderShoppingCart = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart();
$orderShoppingCart->setDetails($details)
                  ->setOrderReference(ORDER_ID)
                  ->setPromotedAmount(0)
    // This amount means that the merchant will assume the interests.
                    ->setTotalAmount('59999');

//3. Configuration Object

$confirmUrl = "http://example.com?action=confirmOrder";
$errorUrl = "http://example.com?action=cancelOrder";

$orderConfigurationUrls = new \Pagantis\OrdersApiClient\Model\Order\Configuration\Urls();
$orderConfigurationUrls->setCancel($errorUrl)
                        ->setKo($errorUrl)
                        ->setAuthorizedNotificationCallback($confirmUrl)
                        ->setRejectedNotificationCallback($confirmUrl)
                        ->setOk($confirmUrl);


$orderChannel = new \Pagantis\OrdersApiClient\Model\Order\Configuration\Channel();
$orderChannel->setAssistedSale(false)
            ->setType(\Pagantis\OrdersApiClient\Model\Order\Configuration\Channel::ONLINE);

$orderConfiguration = new \Pagantis\OrdersApiClient\Model\Order\Configuration();
$orderConfiguration->setChannel($orderChannel)
                    ->setUrls($orderConfigurationUrls);



$order = new \Pagantis\OrdersApiClient\Model\Order();
$order->setConfiguration($orderConfiguration)
        ->setShoppingCart($orderShoppingCart)
        ->setUser($orderUser);


$publicKey = env('PAGANTIS_PUBLIC_KEY');
$privateKey = env('PAGANTIS_PRIVATE_KEY');

$orderClient = new \Pagantis\OrdersApiClient\Client($publicKey, $privateKey);
$order = $orderClient->createOrder($order);


if (!isOrderIdValid($order)) {
    throw new \Exception('Order not valid');
}

//If the order is created and valid then we have the redirection URL here:
$formUrl = $order->getActionUrls()->getForm();
header('Location:' . $formUrl);
                    </code></pre>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer"><a href="https://developer.pagantis.com/index.html#create-order" target="_blank">for more information see </a></footer>

</div>

