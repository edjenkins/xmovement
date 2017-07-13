<?php

$factory->define(App\Idea::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 400),
        'photo' => 'placeholder',
        'visibility' => 'public', //$faker->randomElement($array = array('public','private')),
        'support_state' => 'closed', //$faker->randomElement($array = array('open','closed')),
        'design_state' => 'closed', //$faker->randomElement($array = array('open','closed')),
        'proposal_state' => 'closed', //$faker->randomElement($array = array('open','closed')),
        'supporters_target' => $faker->numberBetween(0,500),
        'duration' => $faker->numberBetween(5,45),
        'design_during_support' => $faker->boolean(),
        'proposals_during_design' => $faker->boolean(),
        'created_at' => $faker->dateTimeBetween($startDate = '-4 days', $endDate = '-2 days'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
    ];
});
