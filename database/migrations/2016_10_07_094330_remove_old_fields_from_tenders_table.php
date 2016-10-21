<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveOldFieldsFromTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenders', function ($table) {
            $table->dropColumn('company_name');
			$table->dropColumn('company_bio');
			$table->dropColumn('contact_email_address');
			$table->dropColumn('company_logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenders', function ($table) {
			$table->string('company_name');
			$table->text('company_bio')->after('company_name');
			$table->string('contact_email_address');
			$table->string('company_logo');
        });

    }
}
