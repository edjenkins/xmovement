<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idea_id')->index();
            $table->integer('user_id')->index();
            $table->string('name', 200);
            $table->string('description', 2000);
            $table->integer('xmovement_task_id')->index();
            $table->string('xmovement_task_type', 200);
            $table->boolean('locked')->default(false);
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
        Schema::drop('design_tasks');
    }
}