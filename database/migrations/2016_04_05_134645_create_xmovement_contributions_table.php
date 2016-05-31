<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXmovementContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xmovement_contributions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('contribution_type', 200);
            $table->string('voting_type', 200);
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
        Schema::drop('xmovement_contributions');
    }
}