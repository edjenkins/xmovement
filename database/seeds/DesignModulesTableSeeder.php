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

		$design_modules = [];

		if (env('APP_XM_MODULE_SCHEDULER', true))
		{
			array_push($design_modules,
				array(
					'name' => 'Scheduler',
					'description' => 'Collaboratively decide on a time/date using the scheduler module as a scheduling assistant.',
					'icon' => 'fa-calendar',
				)
			)
		}

		if (env('APP_XM_MODULE_POLL', true))
		{
			array_push($design_modules,
				array(
					'name' => 'Poll',
					'description' => 'A poll allows people to submit ideas and vote on their favourites, there can be any number of submissions in a poll. A poll might ask used to decide on an event name, the number of people to invite or even what day to have the event. It is possible to lock a poll so only you can add new options.',
					'icon' => 'fa-th-list',
				)
			)
		}

		if (env('APP_XM_MODULE_REQUIREMENT', true))
		{
			array_push($design_modules,
				array(
					'name' => 'Requirement',
					'description' => 'A requirement is useful if you need a set number of things for an event for example you may need 6 people to present or 4 cameras to record the event. People can nominate themselves to meet a requirement or invite others by email to take responsibility.',
					'icon' => 'fa-check-circle-o',
				)
			)
		}

		if (env('APP_XM_MODULE_CONTRIBUTION', true))
		{
			array_push($design_modules,
				array(
					'name' => 'Contribution',
					'description' => 'A contribution allows people to submit different forms of media and text and vote on them to collaboratively decide which is best. It is possible to lock contrbutions to specific file types such as photos/audio/video/links.',
					'icon' => 'fa-thumbs-o-up',
				)
			)
		}

		if (env('APP_XM_MODULE_EXTERNAL', true))
		{
			array_push($design_modules,
				array(
					'name' => 'External',
					'description' => 'An external resource can be any open resource hosted on an external site. An example might be an online whiteboard or group video chat.',
					'icon' => 'fa-external-link',
				)
			)
		}

		if (env('APP_XM_MODULE_DISCUSSION', true))
		{
			array_push($design_modules,
				array(
					'name' => 'Discussion',
					'description' => 'A discussion is useful if you want to speak about a particular aspect openly and freely with others in the design process. There is no structure to a discussion, which makes it a suitable for many use cases like discussing the theme of the event or asking questions.',
					'icon' => 'fa-comments-o',
				)
			)
		}

		foreach ($design_modules as $design_module)
		{
            DB::table('design_modules')->insert([
                'name' => $design_module['name'],
                'description' => $design_module['description'],
                'icon' => $design_module['icon'],
                'available' => true,
                'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
            ]);
        }

        // Contribution design module
		$contribution_available_types = array(
			array(
				'name' => 'Text',
				'description' => 'A plain text submission',
			),
			array(
				'name' => 'Image',
				'description' => 'An image or photo',
			),
			array(
				'name' => 'Video',
				'description' => 'A link to a video (e.g. Youtube/Vimeo)',
			),
			array(
				'name' => 'File',
				'description' => 'A file upload in any format (.pdf/.pptx)',
			),
		);

		foreach ($contribution_available_types as $contribution_available_type)
		{
            DB::table('xmovement_contribution_available_types')->insert([
                'name' => $contribution_available_type['name'],
                'description' => $contribution_available_type['description'],
                'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
            ]);
        }
    }
}
