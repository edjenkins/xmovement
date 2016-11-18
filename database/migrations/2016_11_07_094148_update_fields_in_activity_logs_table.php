<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsInActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('activity_logs', function($table)
		{
			$table->text('request')->nullable()->change();
			$table->text('response')->nullable()->change();
			$table->text('data')->nullable()->change();
			$table->text('method')->nullable()->change();
			$table->text('path')->nullable()->change();
			$table->text('url')->nullable()->change();
			$table->text('full_url')->nullable()->change();
			$table->text('action')->nullable()->change();
			$table->text('parameters')->nullable()->change();
			$table->text('ip')->nullable()->change();
			$table->text('referer')->nullable()->change();
			$table->text('user_agent')->nullable()->change();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('activity_logs', function($table)
		{
			$table->string('request')->change();
			$table->text('response')->change();
			$table->text('data')->change();
			$table->string('method')->change();
			$table->string('path')->change();
			$table->string('url')->change();
			$table->string('full_url')->change();
			$table->string('action')->change();
			$table->text('parameters')->change();
			$table->string('ip')->change();
			$table->string('referer')->change();
			$table->string('user_agent')->change();
		});
    }
}
