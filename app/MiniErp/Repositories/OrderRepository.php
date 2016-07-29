<?php
namespace MiniErp\Repositories;

use MiniErp\Entities\Order;
use MiniErp\Constants\OrderStatus;
use MiniErp\Constants\ItemPhysicalStatus;

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
		return $this->orders->all();
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
	 * Change the status of this order to "Completed"
	 * if all of its items are delivered
	 * 
	 * @param  MiniErp\Entities\Order $order
	 * @return boolean
	 */
	public function complete(Order $order){
		if($this->allItemsDelivered($order)){
			$this->orders->where('id', $order->id)->update(['status' => OrderStatus::Completed]);
			return true;
		}

		return false;
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

	/**
	 * Check if all items have been delivered for a specific order
	 *
	 * @param MiniErp\Entities\Order $order
	 * @return [type] [description]
	 */
	public function allItemsDelivered(Order $order){
		$orderedItems = $order->items()->get();

		$deliveredItems = $orderedItems->filter(function ($item) {
    		return $item->physical_status == ItemPhysicalStatus::Delivered;
		});

		if($deliveredItems->count() == $orderedItems->count()){
			return true;
		}

		return false;
	}


}