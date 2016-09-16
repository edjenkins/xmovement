<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspirationsInspirationCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('inspirations_inspiration_categories', function (Blueprint $table) {
			$table->integer('inspiration_id');
			$table->integer('inspiration_category_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('inspirations_inspiration_categories');
    }
}
