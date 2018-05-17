<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('paid_total', 10,2)->default(0.0)->after('description');
            $table->decimal('total_fees', 10,2)->default(0.0)->after('paid_total');
            $table->unsignedInteger('school_year_id')->after('total_fees');
            $table->unsignedInteger('semester_id')->after('school_year_id');
            $table->unsignedInteger('currency_id')->after('semester_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
}
