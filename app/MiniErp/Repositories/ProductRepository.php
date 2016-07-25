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
		return $this->products->all();
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
}