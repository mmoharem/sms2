<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGradeGpaIntoMarkSystems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mark_systems', function (Blueprint $table) {
	        $table->enum('grade_gpa',['grade','gpa'])->after('title')->default('grade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mark_systems', function (Blueprint $table) {
            $table->dropColumn('grade_gpa');
        });
    }
}
