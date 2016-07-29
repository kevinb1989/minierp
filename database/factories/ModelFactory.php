<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(MiniErp\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(MiniErp\Entities\Product::class, function (Faker\Generator $faker) {
    return [
        'sku' => $faker->isbn10,
        'colour' => $faker->colorName
    ];
});

$factory->define(MiniErp\Entities\Order::class, function (Faker\Generator $faker) {
    return [
        'customer_name' => $faker->name,
        'address' => $faker->address,
        'status' => 'In progress'
    ];
});

$factory->define(MiniErp\Entities\Item::class, function (Faker\Generator $faker) {
    return [
        'order_id' => $faker->randomElement(MiniErp\Entities\Order::lists('id')->toArray()),
        'product_id' => $faker->randomElement(MiniErp\Entities\Product::lists('id')->toArray()),
        'status' => 'Available',
        'physical_status' => 'In warehouse'
    ];
});
