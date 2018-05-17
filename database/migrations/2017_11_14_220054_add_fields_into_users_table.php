<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('marital_status_id')->nullable()->default(null)->after('birth_city');
            $table->unsignedInteger('entry_mode_id')->nullable()->default(null)->after('marital_status_id');
            $table->unsignedInteger('country_id')->nullable()->default(null)->after('entry_mode_id');
            $table->unsignedInteger('no_of_children')->nullable()->default(null)->after('country_id');
            $table->unsignedInteger('religion_id')->nullable()->default(null)->after('country_id');
            $table->string('disability')->nullable()->default(null)->after('country_id');
            $table->string('contact_relation')->nullable()->default(null)->after('disability');
            $table->string('contact_name')->nullable()->default(null)->after('contact_relation');
            $table->string('contact_address')->nullable()->default(null)->after('contact_name');
            $table->string('contact_phone')->nullable()->default(null)->after('contact_address');
            $table->string('contact_email')->nullable()->default(null)->after('contact_phone');
            $table->unsignedInteger('denomination_id')->nullable()->default(null)->after('contact_email');
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
	        $table->dropColumn('marital_status_id');
	        $table->dropColumn('entry_mode_id');
	        $table->dropColumn('country_id');
	        $table->dropColumn('no_of_children');
	        $table->dropColumn('religion_id');
	        $table->dropColumn('disability');
	        $table->dropColumn('contact_relation');
	        $table->dropColumn('contact_name');
	        $table->dropColumn('contact_address');
	        $table->dropColumn('contact_phone');
	        $table->dropColumn('contact_email');
	        $table->dropColumn('denomination_id');
        });
    }
}
