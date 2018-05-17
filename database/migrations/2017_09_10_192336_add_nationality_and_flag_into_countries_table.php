<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNationalityAndFlagIntoCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
        	$table->string('nationality')->nullable()->default(null)->after('name');
        	$table->string('country_flag')->nullable()->default(null)->after('nationality');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
	        $table->dropColumn('nationality');
	        $table->dropColumn('country_flag');
        });
    }
}
