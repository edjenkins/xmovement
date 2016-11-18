<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSupportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('supporters');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('supporters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idea_id');
            $table->string('user_id');
            $table->timestamps();
        });
    }
}
