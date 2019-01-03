<?php

use Faker\Generator as Faker;

$factory->define(App\Service::class, function (Faker $faker) {

    return [
        'title' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'site' => $faker->url,
        'starttime' => $faker->randomNumber(2),
        'stopttime' => $faker->randomNumber(2),
        'check' => $faker->numberBetween(25, 700),
        'kitchen' => $faker->randomNumber(2),
        'address' => $faker->address,
        'description' => $faker->realText(500, 2),
    ];
});
