<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatesToIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function ($table) {
			$table->string('support_state')->after('visibility')->default('closed');
			$table->string('design_state')->after('support_state')->default('closed');
			$table->string('proposal_state')->after('design_state')->default('closed');
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
			$table->dropColumn('support_state');
			$table->dropColumn('design_state');
			$table->dropColumn('proposal_state');
        });
    }
}
