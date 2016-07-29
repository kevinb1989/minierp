<?php
namespace MiniErp\OrderProcessing;

use MiniErp\Repositories\ItemRepository;
use MiniErp\Repositories\OrderRepository;

/**
 * The OrderProcessor class process an order request,
 * which has been decode from json to array type.
 *
 * This class process an order request in three steps:
 * - Extract specific information from the order request, 
 *   including the order information and the list of ordered items
 * - it persist a new order record in orders table
 * - Finally it generate ordered items in items table, taking
 *   into account the available items in the items table
 *
 * @category OrderProcessing
 * @package MiniErp\OrderProcessing
 * @author Kevin Bui
 * @version 0.1
 * 
 */
class OrderProcessor{
	
	private $orderRepo;

	private $updateOrGenerateOrderItems;

	public function __construct(OrderRepository $orderRepo, UpdateOrGenerateOrderItems $updateOrGenerateOrderItems){
		$this->orderRepo = $orderRepo;
		$this->updateOrGenerateOrderItems = $updateOrGenerateOrderItems;
	}

	/**
	 * Process an order, including:
	 * - persist an order
	 * - update and persist its associated items in items table
	 * 
	 * @param  array $input including customer_name, address and a list of items 
	 * @return boolean whether new products are generated due to this order or not
	 */
	public function processOrder($input){
		//extract the customer_name and address from the $input
		$order = $this->extractOrderInfo($input);
		$items = $this->extractItems($input);

		//create a new order record in database
		$newOrder = $this->orderRepo->makeOrder($order);
		
		//update and generate items in database to match the newly created order
		$newProductsCreated = $this->updateOrGenerateOrderItems->updateOrGenerateOrderItems($newOrder->id, $items);

		return $newProductsCreated;
	}

	/**
	 * Extract the customer_name and address,
	 * add the status value, and return an array of these
	 * 
	 * @param  array $input including customer_name, address and status
	 * @return array
	 */
	private function extractOrderInfo($input){
		$order = array_slice($input['order'], 0, 2);

		$order['status'] = 'In progress';

		//because the request contains a key named "customer"
		//whereas the orders table has the customer_name field
		//we have to fix this
		$order['customer_name'] = $order['customer'];
		unset($order['customer']);

		return $order;
	}

	/**
	 * Extract all the items from the order
	 * 
	 * @param  array $input
	 * @return array
	 */
	private function extractItems($input){
		return $input['order']['items'];
	}
}