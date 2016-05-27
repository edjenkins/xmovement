
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

        // Create design modules

        $design_modules = [
						['Poll', 'A poll allows people to submit ideas and vote on their favourites, there can be any number of submissions in a poll. A poll might ask used to decide on an event name, the number of people to invite or even what day to have the event. It is possible to lock a poll so only you can add new options.'],
            ['Requirement', 'A requirement is useful if you need a set number of things for an event for example you may need 6 people to present or 4 cameras to record the event. People can nominate themselves to meet a requirement or invite others by email to take responsibility.'],
            ['Discussion', 'A discussion is useful if you want to speak about a particular aspect openly and freely with others in the design process. There is no structure to a discussion, which makes it a suitable for many use cases like discussing the theme of the event or asking questions.'],
            ['Contribution', 'A contribution allows people to submit different forms of media and text and vote on them to collaboratively decide which is best. It is possible to lock contrbutions to specific file types such as photos/audio/video/links.'],
						['External', 'An external resource can be any open resource hosted on an external site. An example might be an online whiteboard or group video chat.']
        ];

        for ($i=0; $i < count($design_modules); $i++) {
            $name = $design_modules[$i][0];
            $description = $design_modules[$i][1];

            // Add design modules
            DB::table('design_modules')->insert([
                'name' => $name,
                'description' => $description,
                'available' => true,
                'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
            ]);
        }

        // Contribution design module

        $contribution_available_types = [
            ['Text', 'A plain text submission'],
            ['Image', 'An image or photo'],
            ['Video', 'A link to a video (e.g. Youtube/Vimeo)'],
            ['File', 'A file upload in any format (.pdf/.pptx)']
        ];

        for ($i=0; $i < count($contribution_available_types); $i++)
        {
            DB::table('xmovement_contribution_available_types')->insert([
                'name' => $contribution_available_types[$i][0],
                'description' => $contribution_available_types[$i][1],
                'created_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-10 days', $endDate = '-6 days'),
            ]);
        }

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
