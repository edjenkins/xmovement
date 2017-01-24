<?php

use Illuminate\Database\Seeder;

class DynamicConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$configs = [];

		// Add module configs
		array_push($configs,
			array(
				'key' => 'XMOVEMENT_SCHEDULER',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'XMOVEMENT_POLL',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'XMOVEMENT_REQUIREMENT',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'XMOVEMENT_CONTRIBUTION',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'XMOVEMENT_EXTERNAL',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'XMOVEMENT_DISCUSSION',
				'value' => true,
				'type' => 'boolean'
			)
		);

		// Add phase configs
		array_push($configs,
			array(
				'key' => 'INSPIRATION_PHASE_ENABLED',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'CREATION_PHASE_ENABLED',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'SHORTLIST_PHASE_ENABLED',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'TENDER_PHASE_ENABLED',
				'value' => true,
				'type' => 'boolean'
			)
		);

		// Add mode configs
		array_push($configs,
			array(
				'key' => 'INSPIRATION_MODE_ENABLED',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'CREATION_MODE_ENABLED',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'SHORTLIST_MODE_ENABLED',
				'value' => true,
				'type' => 'boolean'
			)
		);

		// Add other configs
		array_push($configs,
			array(
				'key' => 'PRE_POPULATE_DESIGN_TASKS',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'ALLOW_USER_TO_PRE_POPULATE_DESIGN_TASKS',
				'value' => true,
				'type' => 'boolean'
			)
		);

		// Add other configs
		array_push($configs,
			array(
				'key' => 'FIXED_IDEA_DURATION',
				'value' => 0,
				'type' => 'integer'
			)
		);

		foreach ($configs as $config)
		{
			DB::table('configs')->insert([
				'key' => $config['key'],
				'value' => $config['value'],
				'type' => $config['type']
			]);
		}

    }
}
