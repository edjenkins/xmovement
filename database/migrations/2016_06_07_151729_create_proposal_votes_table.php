<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposal_id')->index();
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
        Schema::drop('proposal_votes');
    }
}
