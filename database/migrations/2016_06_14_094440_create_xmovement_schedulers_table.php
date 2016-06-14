<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXmovementSchedulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xmovement_schedulers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
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
        Schema::drop('xmovement_schedulers');
    }
}
