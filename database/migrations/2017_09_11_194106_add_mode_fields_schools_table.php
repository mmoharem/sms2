<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
	        $table->string('tax_no')->nullable()->default(null)->after('title');
	        $table->string('school_no')->nullable()->default(null)->after('tax_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
	        $table->dropColumn('tax_no');
	        $table->dropColumn('school_no');
        });
    }
}
