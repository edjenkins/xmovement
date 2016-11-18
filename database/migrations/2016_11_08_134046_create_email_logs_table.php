<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->nullable();
			$table->string('to')->nullable();
			$table->string('subject')->nullable();
			$table->text('cc')->nullable();
			$table->text('bcc')->nullable();
			$table->text('body')->nullable();
			$table->text('headers')->nullable();
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
        Schema::drop('email_logs');
    }
}
