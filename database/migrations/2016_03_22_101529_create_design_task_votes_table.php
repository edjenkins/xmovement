<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignTaskVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_task_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('design_task_id')->index();
            $table->integer('user_id')->index();
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
        Schema::drop('design_task_votes');
    }
}