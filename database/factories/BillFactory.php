<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bill;
use App\Klass;
use App\Subject;
use Faker\Generator as Faker;

$factory->define(Bill::class, function (Faker $faker) {
    return [
        'klass_id' => Klass::inRandomOrder()->first()->id,
        'subject_id' => $faker->randomElement(NULL, Subject::inRandomOrder()->first()->id),
        'name' => $faker->word,
        'amount' => $faker->randomElement([2000, 10000, 15000, 20000]),
    ];
});
