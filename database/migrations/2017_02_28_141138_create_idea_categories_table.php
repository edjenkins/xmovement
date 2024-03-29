<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeaCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('idea_categories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('enabled')->default(true);
			$table->integer('parent_id')->nullable();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('idea_categories');
    }
}
