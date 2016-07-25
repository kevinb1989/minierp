<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/array-to-json', function(){
	$input = [
    		'order' => [
    			'customer_name' => 'Gabriel Jaramillo',
    			'address' => 'test_address',
    			'total' => 100,
    			'items' => [
    				['sku' => 'testsku1', 'quantity' => 2],
    				['sku' => 'testsku2', 'quantity' => 1]
    			] 
    		]
    ];

    dd(json_encode($input));
});

Route::get('/array-shift', function(){
	$items = [
        ['sku' => 'productsku01', 'quantity' => 2],
        ['sku' => 'productsku02', 'quantity' => 4]
    ];

    $skuList = "";

    while($item = array_shift($items)){
        $skuList .= ' ' . $item['sku'] ;
    }

    dd($skuList);
});
