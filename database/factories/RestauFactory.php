<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Restau::class, function (Faker $faker) {
    return [
        'name' => $faker->name . ' Restaurant',
        'parking' => $faker->boolean,
        'delivery' => $faker->boolean,
        'opening' => $faker->time('H:i', '09:00'),
        'closing' => $faker->time('H:i'),
        'min_price' => 1000 * $faker->numberBetween(3, 4),
        'max_price' => 1000 * $faker->numberBetween(10, 20),
        'description' => $faker->text(100),
        'contact_id' => $faker->unique()->numberBetween(1, 100),
    ];
});
