# BETA ~ Orders Api Client <img src="https://pagamastarde.com/img/icons/logo.svg" width="100" align="right">

[![Build Status](https://travis-ci.org/PagaMasTarde/ordersApiClient.svg?branch=master)](https://travis-ci.org/PagaMasTarde/ordersApiClient)
[![Latest Stable Version](https://poser.pugx.org/pagamastarde/orders-api-client/v/stable)](https://packagist.org/packages/pagamastarde/orders-api-client)
[![composer.lock](https://poser.pugx.org/pagamastarde/orders-api-client/composerlock)](https://packagist.org/packages/pagamastarde/orders-api-client)
[![Maintainability](https://api.codeclimate.com/v1/badges/c777428d857cccb6bfca/maintainability)](https://codeclimate.com/github/PagaMasTarde/ordersApiClient/maintainability)

## TODO
* Test each single function
* Add pending methods
* mapping: double check refunds and upsell add from json

Orders API Client offers the merchants working with Paga+Tarde a way to consume the API services without the effort of doing a complete development.
The library provides stubs for each type of object withing the API and the method calls. Each Method supported by the API is implemented in this client and
is documented within the code and [here](https://developer-staging.pagamastarde.com/api/)

All the code is tested and inspected by external services.

## How to use

Install the library by:

- Downloading it from [here](https://github.com/PagaMasTarde/ordersApiClient/releases/latest)

https://github.com/PagaMasTarde/ordersApiClient/releases/latest

- Using Composer:
```php
composer require pagamastarde/orders-api-client
```
Finally, be sure to include the autoloader:
```php
require_once '/path/to/your-project/vendor/autoload.php';
```

Once you have the library ready inside your project you will have the stub objects available and
the ordersApiClient also available.

```php
//Create a pmtApi object, for example:
$ordersApiClient = new OrdersApiCLient($publicKey, $privateKey);

//Example: get an existing Order status:
$order = $ordersApiClient->getOrder($pmtOrderId); //$pmOrderId is the id of the order
if ($order instaceof PagaMasTarde/OrderApiClient/Order) {
    $orderStatus = $order->getStatus();
    echo $orderStatus;
}

// You can investigate the rest of the methods. And find all the documentation of the API here:
// https://developer-staging.pagamastarde.com/api/

```

## Help us to improve

We are happy to accept suggestions or pull requests. If you are willing to help us develop better software
please create a pull request here following the PSR-2 code style and we will use reviewable to check
the code and if al test pass and no issues are detected by SensioLab Insights you could will be ready
to merge. 

* [Issue Tracker](https://github.com/PagaMasTarde/ordersApiClient/issues)
