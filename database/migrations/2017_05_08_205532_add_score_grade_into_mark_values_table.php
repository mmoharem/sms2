<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreGradeIntoMarkValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mark_values', function (Blueprint $table) {
	        $table->renameColumn('title', 'grade')->nullable()->default(null);;
        });
        Schema::table('mark_values', function (Blueprint $table) {
	        $table->double('max_score',5,2)->after('grade')->nullable()->default(null);
	        $table->double('min_score',4,2)->after('max_score')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mark_values', function (Blueprint $table) {
	        $table->dropColumn('grade', 'title');
	        $table->dropColumn('min_score');
	        $table->dropColumn('max_score');
        });
    }
}
