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

		// Add phase defaults
		array_push($configs,
			array(
				'key' => 'SUPPORT_PHASE',
				'value' => '{"name":"Support","start":0,"end":2,"duration":2,"enabled":true,"rules":[{"type":"MIN_DURATION","value":2},{"type":"MAX_DURATION","value":60}]}',
				'type' => 'json'
			),
			array(
				'key' => 'INSPIRATION_PHASE',
				'value' => '{"name":"Inspiration","start":0,"end":13,"duration":13,"enabled":true,"rules":[{"type":"MIN_DURATION","value":2},{"type":"MAX_DURATION","value":60}]}',
				'type' => 'json'
			),
			array(
				'key' => 'CREATION_PHASE',
				'value' => '{"name":"Creation","start":0,"end":2,"duration":2,"enabled":true,"rules":[{"type":"MIN_DURATION","value":2},{"type":"MAX_DURATION","value":60},{"type":"START_EQUAL","target_phase":"SUPPORT_PHASE"},{"type":"END_NOT_AFTER_END","target_phase":"SUPPORT_PHASE"}]}',
				'type' => 'json'
			),
			array(
				'key' => 'DESIGN_PHASE',
				'value' => '{"name":"Design","start":2,"end":4,"duration":2,"enabled":true,"rules":[{"type":"MIN_DURATION","value":2},{"type":"MAX_DURATION","value":60},{"type":"NOT_BEFORE_START","target_phase":"SUPPORT_PHASE"}]}',
				'type' => 'json'
			),
			array(
				'key' => 'PLAN_PHASE',
				'value' => '{"name":"Plan","start":4,"end":8,"duration":4,"enabled":true,"rules":[{"type":"MIN_DURATION","value":2},{"type":"MAX_DURATION","value":60},{"type":"NOT_BEFORE_END","target_phase":"DESIGN_PHASE"}]}',
				'type' => 'json'
			),
			array(
				'key' => 'SHORTLIST_PHASE',
				'value' => '{"name":"Shortlist","start":13,"end":16,"duration":3,"enabled":true,"rules":[{"type":"MIN_DURATION","value":2},{"type":"MAX_DURATION","value":60},{"type":"NOT_BEFORE_END","target_phase":"PLAN_PHASE"}]}',
				'type' => 'json'
			),
			array(
				'key' => 'TENDER_PHASE',
				'value' => '{"name":"Tender","start":8,"end":14,"duration":6,"enabled":true,"rules":[{"type":"MIN_DURATION","value":2},{"type":"MAX_DURATION","value":60},{"type":"NOT_BEFORE_END","target_phase":"PLAN_PHASE"},{"type":"NOT_BEFORE_END","target_phase":"PLAN_PHASE"}]}',
				'type' => 'json'
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
			),
			array(
				'key' => 'PROGRESSION_TYPE',
				'value' => 'fluid',
				'type' => 'string'
			),
			array(
				'key' => 'TENDER_SHORTLIST_ONLY',
				'value' => true,
				'type' => 'boolean'
			),
			array(
				'key' => 'PROCESS_START_DATE',
				'value' => '2017-02-01T00:00:00.000Z',
				'type' => 'timestamp'
			)

		);

		foreach ($configs as $config)
		{

			$dynamic_config = DynamicConfig\Config::where('key', '=', $config['key'])->first();
			if ($dynamic_config === null) {
				DynamicConfig\Config::firstOrCreate([
    				'key' => $config['key'],
    				'value' => $config['value'],
    				'type' => $config['type']
    			]);
			}
		}

    }
}
