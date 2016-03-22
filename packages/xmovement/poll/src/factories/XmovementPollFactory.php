<?php

$factory->define(XMovement\Poll\Poll::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 50),
        'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        'description' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'contribution_type' => 'text',
        'voting_type' => 'standard',
        'locked' => 0,
        'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
    ];
});

$factory->define(XMovement\Poll\PollOptions::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 50),
        'xmovement_poll_id' => 1,
        'value' => $faker->sentence($nbWords = 1, $variableNbWords = true),
        'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
    ];
});