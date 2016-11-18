<?php

$factory->define(App\Proposal::class, function (Faker\Generator $faker) {
    return [
		'idea_id' => 1,
		'user_id' => 1,
        'description' => $faker->text($maxNbChars = 200),
        'body' => '[{"type":"text","text":"Test proposal"},]',
        'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-6 days', $endDate = '-4 days'),
    ];
});
