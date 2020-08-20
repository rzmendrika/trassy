<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Acc\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'bed_numbers' => $faker->numberBetween(1, 4),
        'tv' => $faker->boolean,
        'safe' => $faker->boolean,
        'kitchen' => $faker->boolean,
        'price' => 100 * $faker->numberBetween(1, 100),
        'shower' => strval( $faker->numberBetween(0, 2) ),
        'wc' => strval( $faker->numberBetween(0, 2) ),
        'description' => $faker->text(100),
        'category_id' => $faker->numberBetween(1, 5)
    ];
});
