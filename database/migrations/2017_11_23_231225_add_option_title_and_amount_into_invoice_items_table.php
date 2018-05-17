<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionTitleAndAmountIntoInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('option_title')->nullable()->default(null)->after('invoice_id');
            $table->decimal('option_amount', 10, 2)->nullable()->default(null)->after('option_title');
        });
        Schema::table('payment_items', function (Blueprint $table) {
            $table->string('option_title')->nullable()->default(null)->after('payment_id');
            $table->decimal('option_amount', 10, 2)->nullable()->default(null)->after('option_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn('option_title');
            $table->dropColumn('option_amount');
        });
        Schema::table('payment_items', function (Blueprint $table) {
            $table->dropColumn('option_title');
            $table->dropColumn('option_amount');
        });
    }
}
