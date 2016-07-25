<?php
namespace MiniErp\Repositories;

/**
 * The OrderRepository class manipulates the orders table.
 * It accesses some data from the items table.
 *
 * @category Repositories
 * @package MiniErp\Repositories
 * @author Kevin Bui
 * @version 0.1
 * 
 */
use MiniErp\Entities\Order;

class OrderRepository{

	private $orders;

	public function __construct(Order $orders){
		$this->orders = $orders;
	}
	
	/**
	 * Retrieve all orders from the database
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAllOrders(){
		return $this->orders->with('items')->get();
	}

	/**
	 * Retrieve a specific order by its id
	 * 
	 * @param  int $orderId
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getOrder($orderId){
		return $this->orders->with('items')->find($orderId);
	}

	/**
	 * Update the status of a specified order
	 * 
	 * @param  array $input the $input array consists of both the order id and the new status
	 * @return int the number of records that have been updated
	 */
	public function changeStatus($input){
		return $this->orders->where('id', $input['id'])->update($input);
	}

	/**
	 * Make an order record in the database and that's it!
	 * The items associated with this order is handled in 
	 * the MiniErp\OrderProcessing\OrderProcessor class
	 * 
	 * @param  array $input includes customer_name, address and status
	 * @return MiniErp\Entities\Order
	 */
	public function makeOrder($input){
		return $this->orders->create($input);
	}


}