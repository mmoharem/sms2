<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentsModeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
	        $table->unsignedInteger('intake_period_id')->nullable()->default(null)->after('school_id');
	        $table->unsignedInteger('level_of_adm')->nullable()->default(null)->after('intake_period_id');
	        $table->unsignedInteger('level_id')->nullable()->default(null)->after('level_of_adm');
	        $table->unsignedInteger('dormitory_id')->nullable()->default(null)->after('level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
	        $table->dropColumn('intake_period_id');
	        $table->dropColumn('level_of_adm');
	        $table->dropColumn('level_id');
	        $table->dropColumn('dormitory_id');
        });
    }
}
