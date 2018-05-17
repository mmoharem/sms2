<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeFieldsFeeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->unsignedInteger('school_id')->after('title');
            $table->decimal('amount')->after('school_id');
            $table->unsignedInteger('currency_id')->after('amount');
            $table->unsignedInteger('fees_period_id')->after('currency_id');
            $table->unsignedInteger('section_id')->nullable()->default(null)->after('fees_period_id');
            $table->unsignedInteger('user_id')->nullable()->default(null)->after('section_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_categories', function (Blueprint $table) {
	        $table->dropColumn('school_id');
	        $table->dropColumn('amount');
	        $table->dropColumn('currency_id');
	        $table->dropColumn('fees_period_id');
	        $table->dropColumn('section_id');
	        $table->dropColumn('user_id');
        });
    }
}
