<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'travel_id' => factory(\App\Travel::class),
        'completed' => false
    ];
});
