<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Appointment;
use App\Model\Customer;
use App\Model\Home;
use App\Model\User;

use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'customer_id' => function(){ return Customer::all()->random(); },
        'home_id' => function(){ return Home::all()->random(); },
        'user_id' => function(){ return User::all()->random(); },
        'title' => $faker->word,
        'not' => $faker->paragraph,
        'start' => $faker->time(),
        'status' => $faker->numberBetween(0,1)
    ];
});
