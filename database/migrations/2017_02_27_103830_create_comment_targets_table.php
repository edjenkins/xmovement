<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_targets', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('target_id')->nullable();
			$table->string('target_type')->nullable();
			$table->integer('idea_id')->nullable();
			$table->string('url')->nullable();
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
        Schema::drop('comment_targets');
    }
}
