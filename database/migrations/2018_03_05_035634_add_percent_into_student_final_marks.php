<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPercentIntoStudentFinalMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_final_marks', function (Blueprint $table) {
            $table->double('mark_percent',5,2)->nullable()->default(null)->after('mark_value_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_final_marks', function (Blueprint $table) {
            $table->dropColumn('mark_percent');
        });
    }
}
