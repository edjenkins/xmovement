<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenderQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tender_questions', function (Blueprint $table) {
			$table->increments('id');
			$table->text('question');
			$table->boolean('public')->default(false);
			$table->boolean('enabled')->default(true);
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
		Schema::drop('tender_questions');
    }
}
