<?php

use Illuminate\Database\Seeder;
use Faker\Generator;

class InspirationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(App\Inspiration::class, 12)->create()->each(function($i) {

			// $i
	        
	    });
    }
}
