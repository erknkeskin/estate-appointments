<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'fullname' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'status' => $faker->numberBetween(0,1)
    ];
});
