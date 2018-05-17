<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
	        $table->string('title')->nullable()->default(null)->after('last_name');
	        $table->string('middle_name')->nullable()->default(null)->after('title');
	        $table->string('address_line2')->nullable()->default(null)->after('middle_name');
	        $table->string('address_line3')->nullable()->default(null)->after('address_line2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
	        $table->dropColumn('title');
	        $table->dropColumn('middle_name');
	        $table->dropColumn('address_line2');
	        $table->dropColumn('address_line3');
        });
    }
}
