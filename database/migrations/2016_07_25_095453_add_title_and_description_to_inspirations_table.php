<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleAndDescriptionToInspirationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspirations', function ($table) {
            $table->string('title')->after('type');
			$table->text('description')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspirations', function ($table) {
            $table->dropColumn('title');
			$table->dropColumn('description');
        });
    }
}
