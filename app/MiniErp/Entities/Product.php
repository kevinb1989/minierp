<?php

namespace MiniErp\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * The Product class represents the products table
 *
 * @category Entities
 * @package MiniErp\Entities
 * @author Kevin Bui
 * @version 0.1
 * 
 */
class Product extends Model
{
	/**
	 * the attributes that are mass assignable
	 * 
	 * @var array
	 */
    protected $fillable= ['sku', 'colour'];

    /**
     * Represent one-to-many relationship between Product and Item
     * 
     * @return  Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(){
    	return $this->hasMany(Item::class);
    }
}
