<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subject;
use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'subject_id' => Subject::inRandomOrder()->first()->id,
        'description' => join('<br>', $faker->paragraphs(5)),
        'deadline' => $faker->dateTime()
    ];
});
