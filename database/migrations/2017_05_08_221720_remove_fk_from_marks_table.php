<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFkFromMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('marks', function (Blueprint $table) {
		    $table->dropForeign('marks_school_year_id_foreign');
		    $table->dropForeign('fk_marks_mark_values1');
		    $table->dropForeign('fk_marks_subjects1');
		    $table->dropForeign('fk_marks_users1');
		    $table->dropForeign('fk_marks_students1');
		    $table->dropForeign('fk_marks_mark_types1');
		    $table->dropForeign('fk_marks_semesters1');
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
