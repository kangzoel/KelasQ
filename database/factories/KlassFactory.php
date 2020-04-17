<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use App\Klass;
use Faker\Generator as Faker;

$factory->define(Klass::class, function (Faker $faker) {
    return [
        'code' => time(),
        'name' => $faker->words(3, true),
        'description' => $faker->paragraphs(1, true),
        'default_member_role_id' => Role::where('name', 'regular_member')->first()->id
    ];
});
