<?php

namespace MiniErp\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * The Order class represents the orders table
 *
 * @category Entities
 * @package MiniErp\Entities
 * @author Kevin Bui
 * @version 0.1
 * 
 */
class Order extends Model
{
	/**
	 * the attributes that are mass assignable
	 * 
	 * @var array
	 */
	protected $fillable = ['customer_name', 'address', 'status'];

	/**
	 * Represent the one-many relationship between Order and Item
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function items(){
    	return $this->hasMany(Item::class);
    }
}
