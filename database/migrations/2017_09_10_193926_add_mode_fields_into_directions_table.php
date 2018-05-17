<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsIntoDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directions', function (Blueprint $table) {
            $table->string('code')->nullable()->default(null)->after('duration');
            $table->string('id_code')->nullable()->default(null)->after('code');
            $table->text('description')->nullable()->default(null)->after('id_code');
            $table->unsignedInteger('duration')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directions', function (Blueprint $table) {
	        $table->dropColumn('code');
	        $table->dropColumn('id_code');
	        $table->dropColumn('description');
        });
    }
}
