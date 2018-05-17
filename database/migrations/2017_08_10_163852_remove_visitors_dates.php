<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveVisitorsDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('visitors', function (Blueprint $table) {
		    $table->dropColumn('stay_from');
		    $table->dropColumn('stay_to');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('visitors', function (Blueprint $table) {
		    $table->date('stay_from')->nullable()->after('visitor_no');
		    $table->date('stay_to')->nullable()->after('stay_from');
	    });
    }
}
