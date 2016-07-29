<?php
namespace MiniErp\Repositories;

use MiniErp\Entities\Product;

/**
 * The Product Repository class manipulates the products table.
 *
 * @category Repositories
 * @package MiniErp\Repositories
 * @author Kevin Bui
 * @version 0.1 
 * 
 */
class ProductRepository{

	private $products;

	public function __construct(Product $products){
		$this->products = $products;
	}

	/**
	 * Retrieve all the products from the database
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAllProducts(){
		return $this->products->latest()->get();
	}

	/**
	 * Add a new product
	 * 
	 * @param array $input
	 * @return MiniErp\Entities\Product
	 */
	public function addProduct($input){
		return $this->products->create($input);
	}

	/**
	 * Edit an existing product
	 *
	 * @param  array $input
	 * @return bool
	 */
	public function editProduct($input){
		return $this->products->where('id', $input['id'])->update($input);
	}

	/**
	 * Find a product that have a specified sku.
	 * A null value will be returned if the product doesn't exist
	 * 
	 * @param  string $sku 
	 * @return MiniErp\Entities\Product
	 */
	public function findProductBySku($sku){
		return $this->products->where('sku', $sku)->first();
	}

	/**
	 * Retrieve a product by its id
	 * 
	 * @param  int $id
	 * @return MiniErp\Entities\Product
	 */
	public function findProductById($id){
		return $this->products->find($id);
	}

	/**
	 * Retrieve an associative array,
	 * the key is product id and the name is sku.
	 * We need to retrieve this list when we want to create a new item
	 * 
	 * @return array
	 */
	public function getAllProductNames(){
		return $this->products->lists('sku', 'id');
	}
}