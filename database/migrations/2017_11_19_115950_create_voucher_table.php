<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('prepared_user_id');
            $table->unsignedInteger('debit_account_id');
            $table->unsignedInteger('credit_account_id');
            $table->unsignedInteger('school_year_id');
            $table->unsignedInteger('school_id');
            $table->string('code');
            $table->decimal('amount', 10,2);
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
