<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsSchoolYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_years', function (Blueprint $table) {
	        $table->unsignedInteger('school_id')->nullable()->default(null)->after('title');
	        $table->unsignedInteger('id_code')->nullable()->default(null)->after('school_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_years', function (Blueprint $table) {
	        $table->dropColumn('school_id');
	        $table->dropColumn('id_code');
        });
    }
}
