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
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'XMOVEMENT_POLL',
        'value' => true,
        'type' => 'boolean'
      ),
      array(
        'key' => 'XMOVEMENT_REQUIREMENT',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'XMOVEMENT_CONTRIBUTION',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'XMOVEMENT_EXTERNAL',
        'value' => false,
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
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'CREATION_PHASE_ENABLED',
        'value' => true,
        'type' => 'boolean'
      ),
      array(
        'key' => 'SHORTLIST_PHASE_ENABLED',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'TENDER_PHASE_ENABLED',
        'value' => false,
        'type' => 'boolean'
      )
    );

    // Add user defined default phase durations
    array_push($configs,
      array(
        'key' => 'SHORT_SUPPORT_DURATION',
        'value' => 2,
        'type' => 'integer'
      ),
      array(
        'key' => 'SHORT_DESIGN_DURATION',
        'value' => 3,
        'type' => 'integer'
      ),
      array(
        'key' => 'MEDIUM_SUPPORT_DURATION',
        'value' => 5,
        'type' => 'integer'
      ),
      array(
        'key' => 'MEDIUM_DESIGN_DURATION',
        'value' => 10,
        'type' => 'integer'
      ),
      array(
        'key' => 'LONG_SUPPORT_DURATION',
        'value' => 14,
        'type' => 'integer'
      ),
      array(
        'key' => 'LONG_DESIGN_DURATION',
        'value' => 21,
        'type' => 'integer'
      )
    );

    // Add mode configs
    array_push($configs,
      array(
        'key' => 'INSPIRATION_MODE_ENABLED',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'CREATION_MODE_ENABLED',
        'value' => true,
        'type' => 'boolean'
      ),
      array(
        'key' => 'SHORTLIST_MODE_ENABLED',
        'value' => false,
        'type' => 'boolean'
      )
    );

    // Add other configs
    array_push($configs,
      array(
        'key' => 'PRE_POPULATE_DESIGN_TASKS',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'ALLOW_USER_TO_PRE_POPULATE_DESIGN_TASKS',
        'value' => false,
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
        'key' => 'MIN_SUPPORTER_COUNT',
        'value' => 0,
        'type' => 'integer'
      ),
      array(
        'key' => 'PROCESS_START_DATE',
        'value' => '2017-02-01T00:00:00.000Z',
        'type' => 'timestamp'
      ),
      array(
        'key' => 'BLOG_ENABLED',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'CATEGORIES_ENABLED',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'EXPLORE_PHASE_LOCKED',
        'value' => false,
        'type' => 'boolean'
      ),

      array(
        'key' => 'UNRESTRICTED_DESIGN',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'UNRESTRICTED_PROPOSAL',
        'value' => false,
        'type' => 'boolean'
      ),
      array(
        'key' => 'PROGRESS_BAR_ENABLED',
        'value' => true,
        'type' => 'boolean'
      ),
      array(
        'key' => 'IDEA_TILE_PHASE_ENABLED',
        'value' => true,
        'type' => 'boolean'
      ),
      array(
        'key' => 'IDEA_UPDATES_ENABLED',
        'value' => true,
        'type' => 'boolean'
      ),
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
