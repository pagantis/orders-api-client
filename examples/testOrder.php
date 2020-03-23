<?php

namespace Examples\OrdersApiClient;

use Examples\OrdersApiClient\Controllers\ShopUser;
use Exception;
use Httpful\Exception\ConnectionErrorException;
use Pagantis\OrdersApiClient\Client;
use Pagantis\OrdersApiClient\Exception\ClientException;
use Pagantis\OrdersApiClient\Exception\HttpException;
use Pagantis\OrdersApiClient\Model\Order;
use Pagantis\OrdersApiClient\Model\Order\Configuration;
use Pagantis\OrdersApiClient\Model\Order\Configuration\Channel;
use Pagantis\OrdersApiClient\Model\Order\Configuration\Urls;
use Pagantis\OrdersApiClient\Model\Order\ShoppingCart;
use Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details;
use Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details\Product;
use Pagantis\OrdersApiClient\Model\Order\User;
use Pagantis\OrdersApiClient\Model\Order\User\Address;
use Examples\OrdersApiClient\utils\Log;
use Pagantis\OrdersApiClient\Model\Order\User\OrderHistory;


class testOrder implements OrderExampleInterface
{
    /**
     * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
     */
    const PUBLIC_KEY = 'tk_45fe164c88c646a8a993d755'; //Set your public key
    const PRIVATE_KEY = '4efe623438e14e3d'; //Set your private key
    const ORDER_ID = 'order_4159972708';

    /**
     * Create order in Pagantis
     *
     * @throws ConnectionErrorException
     * @throws ClientException
     * @throws Exception
     */
    function createOrder()
    {
        // There are 3 objects which are mandatory: User object, ShoppingCart object and Configuration object.
        //1. User Object
        Log::write('Creating User object', $withDate = true);
        //TODO MAKE FAKE USER EXTEND ABSTRACT MODEL
        $fakeUSer = new ShopUser();
        $userAddress = $fakeUSer->setAddressInfo();
        Log::write('Adding the address of the user', $withDate = true);
        Log::write(json_encode($userAddress,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            | JSON_PRETTY_PRINT), $withDate = true);
        $orderBillingAddress = $userAddress;

        $orderShippingAddress = new Address();
        $orderShippingAddress
            ->setZipCode('08029')
            ->setFullName('Alberto Escudero Sanchez')
            ->setCountryCode('ES')
            ->setCity('Barcelona')
            ->setAddress('Avenida de la diagonal 525')
            ->setDni('77695544A')
            ->setNationalId('59661738Z')
            ->setFixPhone('931232345')
            ->setMobilePhone('600123124');

        Log::write('Adding the information of the user', $withDate = true);
        $orderUser = new User();
        $orderUser
            ->setFullName('María Sanchez Escudero')
            ->setAddress($userAddress)
            ->setBillingAddress($orderBillingAddress)
            ->setShippingAddress($orderShippingAddress)
            ->setDateOfBirth('1985-12-30')
            ->setEmail('user@my-shop.com')
            ->setFixPhone('911231234')
            ->setMobilePhone('600123123')
            ->setDni('59661738Z')
            ->setNationalId('59661738Z');
        Log::write('Created User object', $withDate = true);

        //2. ShoppingCart Object
        Log::write('Creating ShoppingCart object', $withDate = true);
        Log::write('Adding the purchases of the customer, if there are.',
            $withDate = true);
        $orderHistory = new OrderHistory();
        $orderHistory
            ->setAmount('2499')
            ->setDate('2010-01-31');
        $orderUser->addOrderHistory($orderHistory);

        Log::write('Adding cart products. Minimum 1 required',
            $withDate = true);
        $product = new Product();
        $product
            ->setAmount('59999')
            ->setQuantity('1')
            ->setDescription('TV LG UltraPlana');

        $details = new Details();
        $details->setShippingCost('0');
        $details->addProduct($product);

        $orderShoppingCart = new ShoppingCart();
        $orderShoppingCart
            ->setDetails($details)
            ->setOrderReference(ORDER_ID)
            ->setPromotedAmount(0) // This amount means that the merchant will asume the interests.
            ->setTotalAmount('59999');
        Log::write('Created OrderShoppingCart object', $withDate = true);

        //3. Configuration Object
        Log::write('Creating Configuration object', $withDate = true);
        Log::write('Adding urls to redirect the user according each case',
            $withDate = true);
        $confirmUrl
            = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=confirmOrder";
        $errorUrl
            = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=cancelOrder";
        $orderConfigurationUrls = new Urls();
        $orderConfigurationUrls
            ->setCancel($errorUrl)
            ->setKo($errorUrl)
            ->setAuthorizedNotificationCallback($confirmUrl)
            ->setRejectedNotificationCallback($confirmUrl)
            ->setOk($confirmUrl);

        Log::write('Adding channel info', $withDate = true);
        $orderChannel = new Channel();
        $orderChannel
            ->setAssistedSale(false)
            ->setType(Channel::ONLINE);

        $orderConfiguration = new Configuration();
        $orderConfiguration
            ->setChannel($orderChannel)
            ->setUrls($orderConfigurationUrls);
        Log::write('Created Configuration object', $withDate = true);

        $order = new Order();
        $order
            ->setConfiguration($orderConfiguration)
            ->setShoppingCart($orderShoppingCart)
            ->setUser($orderUser);

        Log::write('Creating OrdersApiClient', $withDate = true);
        if (PUBLIC_KEY == '' || PRIVATE_KEY == '') {
            throw new Exception('You need set the public and private key');
        }
        $orderClient = new Client(PUBLIC_KEY, PRIVATE_KEY);

        Log::write('Creating Pagantis order', $withDate = true);
        $order = $orderClient->createOrder($order);
        if ($order instanceof Order) {
            //If the order is correct and created then we have the redirection URL here:
            $url = $order->getActionUrls()->getForm();
            $_SESSION['order_id'] = $order->getId();
            Log::write(
                json_encode(
                    $order->export(),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    | JSON_PRETTY_PRINT
                )
                , $withDate = true);
        } else {
            throw new Exception('Order not created');
        }

        // You can use our test credit cards to fill the Pagantis form
        Log::write("Redirecting to Pagantis form => $url", $withDate = true);
        header('Location:' . $url);
    }

    /**
     * Confirm order in Pagantis
     *
     * @throws ConnectionErrorException
     * @throws ClientException
     * @throws Exception
     */
    function confirmOrder()
    {
        /* Once the user comes back to the OK url or there is a notification upon callback url you will have to confirm
        * the reception of the order. If not it will expire and will never be paid.
        *
        * Add this parameters in your database when you create a order and map it to your own order. Or search orders by
        * your own order id. Both options are possible.
        */

        Log::write('Creating OrdersApiClient', $withDate = true);
        $orderClient = new Client(PUBLIC_KEY, PRIVATE_KEY);

        $order = $orderClient->getOrder($_SESSION['order_id']);

        if ($order instanceof Order
            && $order->getStatus() == Order::STATUS_AUTHORIZED
        ) {
            //If the order exists, and the status is authorized, means you can mark the order as paid.

            //DO WHATEVER YOU NEED TO DO TO MARK THE ORDER AS PAID IN YOUR OWN SYSTEM.
            Log::write('Confirming order', $withDate = true);
            $order = $orderClient->confirmOrder($order->getId());

            Log::write('Order confirmed', $withDate = true);
            Log::write(
                json_encode(
                    $order->export(),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    | JSON_PRETTY_PRINT
                )
                , $withDate = true);
            $message
                = "The order {$_SESSION['order_id']} has been confirmed successfully";
        } else {
            $message = "The order {$_SESSION['order_id']} can't be confirmed";
        }

        /* The order has been marked as paid and confirmed in Pagantis so you will send the product to your customer and
        * Pagantis will pay you in the next 24h.
        */

        echo $message;
        exit;
    }

    /**
     * Action after redirect to cancelUrl
     */
    function cancelOrder()
    {
        $message = "The order {$_SESSION['order_id']} can't be created";

        echo $message;
        exit;
    }

}