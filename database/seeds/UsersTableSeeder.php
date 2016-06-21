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
	    factory(App\User::class, 5)->create()->each(function($u) {

	        // $u->ideas()->save(factory(App\Idea::class)->make());

			$faker = Faker\Factory::create();

			$events = array(
				array(
					'name' => 'BBQ in the Park',
					'description' => 'The weather is amazing in Newcastle, let\'s have a BBQ on the park sometime soon. Everyone\'s welcome!',
				),
				array(
					'name' => 'Python Class',
					'description' => 'I have started to learn Python and would like to run a weekly course in Open Lab for anyone else interested in programming.',
				),
				array(
					'name' => 'Go Karting',
					'description' => 'Let\'s get a big group together to do some karting at the Gateshead track, anyone is welcome and your ideas towards making this awesome are welcomed.',
				),
				array(
					'name' => 'Wedding Party',
					'description' => 'I\'m planning my wedding party and would love any ideas or suggestions towards making it the best ever.',
				),
				array(
					'name' => 'Geordie Festival',
					'description' => 'We should start an annual festival in Newcastle featuring some of the best up and coming local bands in the area. Please show your support and help design the first event!',
				),
			);

			$event = $events[$faker->numberBetween(0, ($u->id) - 1)];

			DB::table('ideas')->insert([
				'user_id' => $u->id,
		        'name' => $event['name'],
		        'description' => $event['description'],
		        'photo' => 'placeholder',
		        'visibility' => $faker->randomElement($array = array('public','private')),
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

	    });
    }
}
