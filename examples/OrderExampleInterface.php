<?php


namespace Examples\OrdersApiClient;


interface OrderExampleInterface
{
	public function createOrder();

	public function confirmOrder();

	public function cancelOrder();

}