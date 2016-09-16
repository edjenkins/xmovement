<?php

$factory->define(App\Inspiration::class, function (Faker\Generator $faker) {
    return [
		'type' => 'photo',
        'title' => $faker->text($maxNbChars = 80),
        'description' => $faker->text($maxNbChars = 400),
        'content' => $faker->imageUrl(400, 200, 'cats', true, false),
		'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-6 days', $endDate = '-4 days'),
    ];
});
