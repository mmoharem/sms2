<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsInTransportationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('transportations', function (Blueprint $table) {
		    $table->text('journey_purpose')->nullable()->default(null)->after('end');
		    $table->string('vehicle_type')->nullable()->default(null)->after('journey_purpose');
		    $table->decimal('fee', 10,2)->nullable()->default(null)->after('vehicle_type');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('transportations', function (Blueprint $table) {
		    $table->dropColumn('journey_purpose');
		    $table->dropColumn('vehicle_type');
		    $table->dropColumn('fee');
	    });
    }
}
