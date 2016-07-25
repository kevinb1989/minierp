<?php
namespace MiniErp\Repositories;
use MiniErp\Entities\Item;

/**
 * The ItemRepository class manipulates the items table.
 * It accesses some data from the products table.
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
}