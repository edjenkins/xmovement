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

        // Create design modules

        $design_modules = [
						['Scheduler', 'Collaboratively decide on a time/date using the scheduler module as a scheduling assistant.', 'fa-calendar'],
						['Poll', 'A poll allows people to submit ideas and vote on their favourites, there can be any number of submissions in a poll. A poll might ask used to decide on an event name, the number of people to invite or even what day to have the event. It is possible to lock a poll so only you can add new options.', 'fa-th-list'],
            ['Requirement', 'A requirement is useful if you need a set number of things for an event for example you may need 6 people to present or 4 cameras to record the event. People can nominate themselves to meet a requirement or invite others by email to take responsibility.', 'fa-check-circle-o'],
            ['Contribution', 'A contribution allows people to submit different forms of media and text and vote on them to collaboratively decide which is best. It is possible to lock contrbutions to specific file types such as photos/audio/video/links.', 'fa-thumbs-o-up'],
						['External', 'An external resource can be any open resource hosted on an external site. An example might be an online whiteboard or group video chat.', 'fa-external-link'],
						['Discussion', 'A discussion is useful if you want to speak about a particular aspect openly and freely with others in the design process. There is no structure to a discussion, which makes it a suitable for many use cases like discussing the theme of the event or asking questions.', 'fa-comments-o']
        ];

        for ($i=0; $i < count($design_modules); $i++) {
            $name = $design_modules[$i][0];
            $description = $design_modules[$i][1];
            $icon = $design_modules[$i][2];

            // Add design modules
            DB::table('design_modules')->insert([
                'name' => $name,
                'description' => $description,
                'icon' => $icon,
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
    }
}
