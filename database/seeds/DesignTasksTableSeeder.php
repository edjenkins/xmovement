<?php

use Illuminate\Database\Seeder;
use Faker\Generator;

class DesignTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

		// Create design tasks

		$design_task_names = array('Venue Name','Primary Speaker','Secondary Speakers','Catering Options');

		for ($i=1; $i <= count($design_task_names); $i++)
		{
			$user_id = $faker->numberBetween($min = 1, $max = 50);
			$idea_id = 1;
			$module_id = $i;

			// Add 10 design modules
			DB::table('design_tasks')->insert([
				'user_id' => $user_id,
				'idea_id' => $idea_id,
				'name' => $design_task_names[($i - 1)],
				'description' => $faker->sentence($nbWords = 5, $variableNbWords = true),
				'xmovement_task_id' => $i,
				'xmovement_task_type' => 'Poll',
				'proposal_interactivity' => true,
				'locked' => $faker->randomElement($array = array(0, 1)),
				'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
				'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
			]);

			// Add 10 polls
			DB::table('xmovement_polls')->insert([
				'user_id' => $faker->numberBetween($min = 1, $max = 50),
				'contribution_type' => 'text',
				'voting_type' => 'standard',
				'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
				'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
			]);

			// Add poll options
			for ($j=1; $j < $faker->numberBetween($min = 1, $max = 10); $j++)
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
