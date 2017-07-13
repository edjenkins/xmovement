<?php

$factory->define(App\Supporter::class, function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get())
    ];
});
