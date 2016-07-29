<?php

namespace MiniErp\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * The Item class represent the items table
 * 
 * @category Entities
 * @package MiniErp\Entities
 * @author Kevin Bui
 * @version 0.1
 */
class Item extends Model
{
	/**
	 * the attributes that are mass assignable
	 * 
	 * @var array
	 */
	protected $fillable = ['order_id', 'product_id', 'status', 'physical_status'];

	/**
	 * Represent the one-to-many relationship between Product and Item
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function product(){
    	return $this->belongsTo(Product::class);
    }

    /**
	 * Represent the one-to-many relationship between Order and Item
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function order(){
    	return $this->belongsTo(Order::class);
    }
}
