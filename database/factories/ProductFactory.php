<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title'       => $faker->company,
        'description' => $faker->realText(100),
        'image'       => $faker->imageUrl,
        'on_sale'     => true,
        'price'       => $faker->randomNumber(4),
    ];
});
