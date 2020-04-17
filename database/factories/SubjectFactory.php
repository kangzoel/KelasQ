<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subject;
use App\Klass;
use Faker\Generator as Faker;

$factory->define(Subject::class, function (Faker $faker) {
    $times = [
        ['07:30:00', '09:00:00'],
        ['09:00:00', '10:30:00'],
        ['10:30:00', '12:00:00'],
        ['12:00:00', '13:30:00'],
        ['13:30:00', '15:00:00'],
    ];

    $pair = $times[rand(0, 4)];

    return [
        'klass_id' => Klass::inRandomOrder()->first()->id,
        'name' => $faker->word,
        'day_of_week' => rand(1, 7),
        'start'=> $pair[0],
        'end'=> $pair[1]
    ];
});
