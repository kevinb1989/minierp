<?php

use Illuminate\Database\Seeder;
use MiniErp\Entities\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 12) as $number){
        	factory(Product::class)->create([
        		'sku' => 'productsku' . $number
        	]);
        }
    }
}
