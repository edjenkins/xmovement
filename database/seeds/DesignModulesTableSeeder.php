<?php

use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Support\Facades\Lang;

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
					'name' => Lang::get('xmovement.scheduler'),
					'description' => Lang::get('xmovement.scheduler_description'),
					'icon' => 'fa-calendar',
				)
			);
		}

		if (env('APP_XM_MODULE_POLL', true))
		{
			array_push($design_modules,
				array(
					'name' => Lang::get('xmovement.poll'),
					'description' => Lang::get('xmovement.poll_description'),
					'icon' => 'fa-th-list',
				)
			);
		}

		if (env('APP_XM_MODULE_REQUIREMENT', true))
		{
			array_push($design_modules,
				array(
					'name' => Lang::get('xmovement.requirement'),
					'description' => Lang::get('xmovement.requirement_description'),
					'icon' => 'fa-check-circle-o',
				)
			);
		}

		if (env('APP_XM_MODULE_CONTRIBUTION', true))
		{
			array_push($design_modules,
				array(
					'name' => Lang::get('xmovement.contribution'),
					'description' => Lang::get('xmovement.contribution_description'),
					'icon' => 'fa-thumbs-o-up',
				)
			);
		}

		if (env('APP_XM_MODULE_EXTERNAL', true))
		{
			array_push($design_modules,
				array(
					'name' => Lang::get('xmovement.external'),
					'description' => Lang::get('xmovement.external_description'),
					'icon' => 'fa-external-link',
				)
			);
		}

		if (env('APP_XM_MODULE_DISCUSSION', true))
		{
			array_push($design_modules,
				array(
					'name' => Lang::get('xmovement.discussion'),
					'description' => Lang::get('xmovement.discussion_description'),
					'icon' => 'fa-comments-o',
				)
			);
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
