<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Home;
use Faker\Generator as Faker;

$factory->define(Home::class, function (Faker $faker) {
    return [
        'title'=> $faker->word,
        'note' => $faker->paragraph,
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude(),
        'status' => $faker->numberBetween(0, 1)
    ];
});
