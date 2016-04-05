<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXmovementContributionOptionVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xmovement_contribution_option_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('xmovement_contribution_option_id');
            $table->integer('user_id');
            $table->integer('value');
            $table->boolean('latest')->default(true);
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
        Schema::drop('xmovement_contribution_option_votes');
    }
}