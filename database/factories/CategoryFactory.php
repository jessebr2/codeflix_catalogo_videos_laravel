<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'description' => rand(1,2) == 1 ? $faker->sentence() : null
    ];
});
