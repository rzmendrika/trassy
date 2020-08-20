<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Acc\Acc;
use Faker\Generator as Faker;

$factory->define(Acc::class, function (Faker $faker) {
    return [
        'name' => $faker->name . ' Hotel',
        'parking' => $faker->boolean,
        'wifi' => $faker->boolean,
        'playground' => $faker->boolean,
        'roomservice' => $faker->boolean,
        'stars' => $faker->numberBetween(1, 4),
        'description' => $faker->text(100),
        'contact_id' => factory(App\Model\Contact::class),
        'user_id' => $faker->numberBetween(1, 3),
    ];
});
