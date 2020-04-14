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
        'file_name' => $faker->randomElement(['public/audio/album/audio.mp3','public/audio/songs/sample.mp3']),
        'type' => $faker->randomElement(['dir','txt','mp3']),
    ];
});
