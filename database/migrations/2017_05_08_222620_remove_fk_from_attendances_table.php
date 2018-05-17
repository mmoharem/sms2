<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFkFromAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('attendances', function (Blueprint $table) {
		    $table->dropForeign('attendances_semester_id_foreign');
		    $table->dropForeign('attendances_subject_id_foreign');
		    $table->dropForeign('attendances_teacher_id_foreign');
		    $table->dropForeign('fk_attendance_students1');
		    $table->dropForeign('attendances_school_year_id_foreign');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
