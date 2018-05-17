<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
	        $table->string('code')->nullable()->default(null)->after('title');
	        $table->string('description')->nullable()->default(null)->after('code');
	        $table->boolean('show')->nullable()->default(null)->after('description');
	        $table->unsignedInteger('level_id')->nullable()->default(null)->after('show');
	        $table->unsignedInteger('semester_id')->nullable()->default(null)->after('level_id');
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
            //
        });
    }
}
