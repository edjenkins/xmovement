<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXmovementContributionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xmovement_contribution_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('xmovement_contribution_id')->index();
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
        Schema::drop('xmovement_contribution_options');
    }
}