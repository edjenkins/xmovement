<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    Model::unguard();

		$this->call(DesignModulesTableSeeder::class);

		if (env('APP_DEBUG', false))
		{
	        $this->call(UsersTableSeeder::class);
			$this->call(InspirationsTableSeeder::class);
		}

	    Model::reguard();
    }
}
