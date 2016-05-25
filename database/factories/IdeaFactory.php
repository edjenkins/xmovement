<?php

$factory->define(App\Idea::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'visibility' => $faker->randomElement($array = array('public','private')),
        'description' => $faker->text($maxNbChars = 400),
        'photo' => $faker->imageUrl($width = 1200, $height = 400),
        'created_at' => $faker->dateTimeBetween($startDate = '-4 days', $endDate = '-2 days'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
    ];
});
