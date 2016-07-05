<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName . ' ' . $faker->lastName,
        'bio' => $faker->text($maxNbChars = 200),
        'email' => strtolower($faker->firstNameMale) . '@edjenkins.co.uk',
        'phone' => $faker->phoneNumber,
        'avatar' => 'avatar',
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-6 days', $endDate = '-4 days'),
    ];
});
