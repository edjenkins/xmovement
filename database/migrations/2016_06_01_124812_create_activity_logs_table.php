<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->increments('id');
			$table->string('request');
			$table->text('response');
			$table->text('data');
			$table->string('method');
			$table->string('path');
			$table->string('url');
			$table->string('full_url');
			$table->string('action');
			$table->text('parameters');
			$table->string('ip');
			$table->string('referer');
			$table->string('user_agent');
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
        Schema::drop('activity_logs');
    }
}
