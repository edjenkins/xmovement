<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPolymorphicFieldsToUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('updates', function ($table) {
            $table->renameColumn('idea_id', 'updateable_id');
			$table->string('updateable_type')->default('idea')->after('idea_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('updates', function ($table) {
            $table->renameColumn('updateable_id', 'idea_id');
            $table->dropColumn('updateable_type');
        });
    }
}
