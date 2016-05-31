<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXmovementContributionAvailableTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xmovement_contribution_available_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('description', 2000);
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
        Schema::drop('xmovement_contribution_available_types');
    }
}