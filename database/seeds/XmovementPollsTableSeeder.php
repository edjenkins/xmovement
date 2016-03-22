<?php

use Illuminate\Database\Seeder;
use Faker\Generator;

class XmovementPollsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker\Factory::create();

        // factory(XMovement\Poll\Poll::class, 5)->create()->each(function($poll) {

        //     // $poll->pollOptions()->save(factory(XMovement\Poll\PollOptions::class, 50)->make());

        //     $faker = Faker\Factory::create();
            
        //     DB::table('xmovement_poll_options')->insert([
        //         'user_id' => $faker->numberBetween($min = 1, $max = 50),
        //         'xmovement_poll_id' => $poll->id,
        //         'value' => $faker->sentence($nbWords = 1, $variableNbWords = true),
        //         'created_at' => '2016-03-11 01:21:04',
        //         'updated_at' => '2016-03-11 01:21:04'
        //     ]);

        // });


        // DB::table('xmovement_polls')->insert([
        //     'user_id' => $faker->numberBetween($min = 1, $max = 50),
        //     'module_id' => 1,
        //     'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        //     'description' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        //     'contribution_type' => 'text',
        //     'voting_type' => 'standard',
        //     'locked' => 0,
        //     'created_at' => '2016-03-11 01:21:04',
        //     'updated_at' => '2016-03-11 01:21:04'
        // ]);

        // DB::table('xmovement_poll_options')->insert([
        //     'user_id' => $faker->numberBetween($min = 1, $max = 50),
        //     'xmovement_poll_id' => 1,
        //     'value' => $faker->sentence($nbWords = 1, $variableNbWords = true),
        //     'created_at' => '2016-03-11 01:21:04',
        //     'updated_at' => '2016-03-11 01:21:04'
        // ]);

        // DB::table('design_modules')->insert([
        //     'user_id' => $faker->numberBetween($min = 1, $max = 50),
        //     'idea_id' => 1,
        //     'type' => 'xmovement_poll',
        //     'created_at' => '2016-03-11 01:21:04',
        //     'updated_at' => '2016-03-11 01:21:04'
        // ]);
    }
}