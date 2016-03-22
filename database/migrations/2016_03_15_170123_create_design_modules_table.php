<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idea_id')->index();
            $table->integer('user_id')->index();
            $table->integer('xmovement_module_id')->index();
            $table->string('xmovement_module_type', 200);
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
        Schema::drop('design_modules');
    }
}