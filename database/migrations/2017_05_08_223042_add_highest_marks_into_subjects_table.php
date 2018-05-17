<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHighestMarksIntoSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('subjects', function (Blueprint $table) {
		    $table->double( 'highest_mark',5,2 )->nullable()->default(null)->after('title');
		    $table->double( 'lowest_mark',5,2 )->nullable()->default(null)->after('highest_mark');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('subjects', function (Blueprint $table) {
		    $table->dropColumn( 'highest_mark' );
		    $table->dropColumn( 'lowest_mark' );
	    });
    }
}
