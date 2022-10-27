<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Product::class, function (Faker $faker) {
    
    $productName =  $faker->sentence(3);

    return [
        'name' => $productName,
        'slug' => Str::slug($productName),
        'description' => $faker->paragraph(5),
        'price' => mt_rand(10,100)/10
    ];
});
