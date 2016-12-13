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

		array_push($design_modules,
			array(
				'name' => 'xmovement.scheduler',
				'description' => 'xmovement.scheduler_description',
				'class' => 'scheduler',
				'icon' => 'fa-calendar',
			),
			array(
				'name' => 'xmovement.poll',
				'description' => 'xmovement.poll_description',
				'class' => 'poll',
				'icon' => 'fa-th-list',
			),
			array(
				'name' => 'xmovement.requirement',
				'description' => 'xmovement.requirement_description',
				'class' => 'requirement',
				'icon' => 'fa-check-circle-o',
			),
			array(
				'name' => 'xmovement.contribution',
				'description' => 'xmovement.contribution_description',
				'class' => 'contribution',
				'icon' => 'fa-thumbs-o-up',
			),
			array(
				'name' => 'xmovement.external',
				'description' => 'xmovement.external_description',
				'class' => 'external',
				'icon' => 'fa-external-link',
			),
			array(
				'name' => 'xmovement.discussion',
				'description' => 'xmovement.discussion_description',
				'class' => 'discussion',
				'icon' => 'fa-comments-o',
			)
		);

		foreach ($design_modules as $design_module)
		{
            DB::table('design_modules')->insert([
                'name' => $design_module['name'],
                'description' => $design_module['description'],
				'class' => $design_module['class'],
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
