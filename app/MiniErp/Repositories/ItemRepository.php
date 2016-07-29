<?php
namespace MiniErp\Repositories;
use MiniErp\Entities\Item;

/**
 * The ItemRepository class manipulates the items table.
 * It accesses some data from the products and orders tables.
 *
 * @category Repositories
 * @package MiniErp\Repositories
 * @author Kevin Bui
 * @version 0.1
 * 
 */
class ItemRepository{

	private $items;

	public function __construct(Item $items){
		$this->items = $items;
	}
	
	/**
	 * Retrieve all items from the database
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAllItems(){
		return $this->items->with('product')->get();
	}

	/**
	 * Add a new item to the database
	 *  
	 * @param array $input
	 */
	public function addItem($input){
		return $this->items->create($input);
	}

	/**
	 * Edit an existing item
	 * 
	 * @param  array $input 
	 * @return int the number of items (records) that are affected
	 */
	public function editItem($input){
		return $this->items->where('id', $input['id'])->update($input);
	}

	/**
	 * Retrieve an item by its id for editing
	 *
	 * @param int $id
	 * @return MiniErp\Entities\Item
	 */
	public function getItemById($id){
		return $this->items->find($id);
	}

	/**
	 * Retrieve the order that contains a specific item
	 * 
	 * @param  int $itemId
	 * @return MiniErp\Entities\Order
	 */
	public function getOrderFromItem($itemId){
		$collection = $this->items->find($itemId)->order()->get();
		
		if(!is_null($collection)){
			return $collection->first();
		}

		return null;
	}
}