<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXmovementContributionSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xmovement_contribution_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('xmovement_contribution_id');
            $table->integer('xmovement_contribution_available_type_id');
            $table->string('value', 2000);
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
        Schema::drop('xmovement_contribution_submissions');
    }
}