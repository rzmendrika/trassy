<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email(),
        'tel1' => $faker->phoneNumber(),
        'tel2' => $faker->phoneNumber(),
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'instagram' => $faker->unique()->name(),
        'facebook'  => $faker->unique()->name(),
        'region' => 'Region ' . $faker->country,
    ];

});
