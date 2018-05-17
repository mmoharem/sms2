<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsSchoolAndLimitSmsPerSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('schools', function (Blueprint $table) {
		    $table->integer('limit_sms_messages')->nullable()->default(null)->after('title');
	    });
	    Schema::table('sms_messages', function (Blueprint $table) {
		    $table->integer('school_id')->nullable()->default(null)->after('user_id_sender');
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
		    $table->dropColumn('limit_sms_messages');
	    });

	    Schema::table('sms_messages', function (Blueprint $table) {
		    $table->dropColumn('school_id');
	    });
    }
}
