<?php

use Illuminate\Database\Seeder;
use Faker\Generator;

class DesignModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $module_names = array('Venue Name','Primary Speaker','Secondary Speakers','Catering Options');

        for ($i=1; $i <= count($module_names); $i++)
        {
            $user_id = $faker->numberBetween($min = 1, $max = 50);
            $idea_id = 1;
            $module_id = $i;

            // Add 10 design modules
            DB::table('design_modules')->insert([
                'user_id' => $user_id,
                'idea_id' => $idea_id,
                'xmovement_module_id' => $i,
                'xmovement_module_type' => 'Poll',
                'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
            ]);
            
            // Add 10 polls
            DB::table('xmovement_polls')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'name' => $module_names[($i - 1)],
                'description' => $faker->sentence($nbWords = 5, $variableNbWords = true),
                'contribution_type' => 'text',
                'voting_type' => 'standard',
                'locked' => $faker->randomElement($array = array(0, 1)),
                'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
            ]);

            // Add poll options
            for ($j=1; $j < $faker->numberBetween($min = 1, $max = 20); $j++)
            {
                DB::table('xmovement_poll_options')->insert([
                    'user_id' => $faker->numberBetween($min = 1, $max = 50),
                    'xmovement_poll_id' => $j,
                    'value' => $faker->sentence($nbWords = 1, $variableNbWords = true),
                    'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                    'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                ]);


                // Add poll option votes
                for ($k=1; $k < $faker->numberBetween($min = 1, $max = 20); $k++)
                {
                    DB::table('xmovement_poll_option_votes')->insert([
                        'user_id' => $faker->numberBetween($min = 1, $max = 50),
                        'xmovement_poll_option_id' => $j,
                        'value' => $faker->randomElement($array = array(-1, 1)),
                        'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                        'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                    ]);
                }
            }
        }
    }
}
