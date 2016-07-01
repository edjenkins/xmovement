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
	    factory(App\User::class, 4)->create()->each(function($u) {

	        $u->proposals()->save(factory(App\Proposal::class)->make());

			$faker = Faker\Factory::create();

			$events = array(
				array(
					'name' => 'BBQ in the Park',
					'description' => 'The weather is amazing in Newcastle, let\'s have a BBQ on the park sometime soon. Everyone\'s welcome!',
					'photo' => '198aaf05f750ec4c7b3c09279565cf870b604871.jpg',
				),
				array(
					'name' => 'Python Class',
					'description' => 'I have started to learn Python and would like to run a weekly course in Open Lab for anyone else interested in programming.',
					'photo' => '5f481255368a90335100fcc418d3688af2894336.jpg',
				),
				array(
					'name' => 'Go Karting',
					'description' => 'Let\'s get a big group together to do some karting at the Gateshead track, anyone is welcome and your ideas towards making this awesome are welcomed.',
					'photo' => 'c46d19daead42a1a2a6230d3780d584da89dcbb8.jpg',
				),
				array(
					'name' => 'Wedding Party',
					'description' => 'I\'m planning my wedding party and would love any ideas or suggestions towards making it the best ever.',
					'photo' => 'e6bde9717001b7cfeb6ec67987734d96007bdeed.jpg',
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
				        'supporters_target' => $faker->numberBetween(0,2000),
				        'duration' => $faker->numberBetween(20,45),
				        'design_during_support' => $faker->boolean(),
				        'proposals_during_design' => $faker->boolean(),
				        'created_at' => $faker->dateTimeBetween($startDate = '-20 days', $endDate = '-2 days'),
				        'updated_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
					]);
				}
			}
	    });
    }
}
