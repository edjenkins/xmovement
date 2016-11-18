<?php

use Illuminate\Database\Seeder;
use Faker\Generator;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(App\User::class, 1)->create()->each(function($u) {

	        $u->proposals()->save(factory(App\Proposal::class)->make());

			$faker = Faker\Factory::create();

			$events = array(
				array(
					'name' => 'Friends Chat',
					'description' => 'An app to connect people with their family and close friends. Using intelligent prompts to initiate conversations based on common activities.',
					'photo' => 'fce80ca77cf9e738b1c3c70e0712d27332971c0f.jpg',
				),
			);

			$exists = true;

			while ($exists)
			{
				$event = $events[$faker->numberBetween(0, ($u->id) - 1)];
				$count = DB::table('ideas')
                ->where('name', $event['name'])
                ->count();

				if ($count == 0)
				{
					$exists = false;

					DB::table('ideas')->insert([
						'user_id' => $u->id,
				        'name' => $event['name'],
				        'description' => $event['description'],
				        'photo' => $event['photo'],
				        'visibility' => 'public',
				        'support_state' => $faker->randomElement($array = array('open','closed')),
				        'design_state' => $faker->randomElement($array = array('open','closed')),
				        'proposal_state' => $faker->randomElement($array = array('open','closed')),
				        'supporters_target' => $faker->numberBetween(0,500),
				        'duration' => $faker->numberBetween(5,45),
				        'design_during_support' => false,
				        'proposals_during_design' => false,
				        'created_at' => $faker->dateTimeBetween($startDate = '-20 days', $endDate = '-2 days'),
				        'updated_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
					]);
				}
			}
	    });
    }
}
