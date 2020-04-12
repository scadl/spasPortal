<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Music;
use Faker\Generator as Faker;

$factory->define(Music::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'description' =>$faker->paragraph(),
        'played' => $faker->randomDigit(),
        'downloads' => $faker->randomDigit(),
        'hidden' => false,
        'file_name' => $faker->imageUrl()
    ];
});
