<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOverlapSettingsToIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function ($table) {
			$table->boolean('design_during_support')->after('duration')->default(false);
			$table->boolean('proposals_during_design')->after('design_during_support')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function ($table) {
			$table->dropColumn('proposals_during_design');
            $table->dropColumn('design_during_support');
        });
    }
}
