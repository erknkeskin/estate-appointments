<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Office;
use Faker\Generator as Faker;

$factory->define(Office::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'address' => $faker->address,
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude(),
        'status' => $faker->numberBetween(0,1)
    ];
});
