<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdCodeIntoSectionsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('sections', function (Blueprint $table) {
		    $table->unsignedInteger('id_code')->after('id')->default(1);
	    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('sections', function (Blueprint $table) {
		    $table->dropColumn('id_code');
	    });
    }
}
