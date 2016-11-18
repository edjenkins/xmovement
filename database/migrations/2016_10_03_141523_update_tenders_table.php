<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenders', function ($table) {
            $table->renameColumn('company', 'company_name');
			$table->string('contact_email_address');
			$table->string('company_logo');
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
            $table->renameColumn('company_name', 'company');
            $table->dropColumn('contact_email_address');
            $table->dropColumn('company_logo');
        });
    }
}
