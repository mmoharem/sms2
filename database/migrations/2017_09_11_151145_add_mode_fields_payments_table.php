<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
	        $table->string('remarks')->nullable()->default(null)->after('description');
	        $table->unsignedInteger('school_year_id')->nullable()->default(null)->after('remarks');
	        $table->unsignedInteger('semester_id')->nullable()->default(null)->after('school_year_id');
	        $table->unsignedInteger('currency_id')->nullable()->default(null)->after('semester_id');
	        $table->string('receipt_number')->nullable()->default(null)->after('currency_id');
	        $table->string('payment_doc')->nullable()->default(null)->after('receipt_number');
	        $table->unsignedInteger('officer_user_id')->nullable()->default(null)->after('payment_doc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
	        $table->dropColumn('remarks');
	        $table->dropColumn('school_year_id');
	        $table->dropColumn('semester_id');
	        $table->dropColumn('currency_id');
	        $table->dropColumn('reciept_number');
	        $table->dropColumn('payment_doc');
	        $table->dropColumn('officer_user_id');
        });
    }
}
