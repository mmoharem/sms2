<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAluminiStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumini_students', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('alumini_id');
	        $table->unsignedInteger('student_id');
	        $table->unsignedInteger('school_id');
	        $table->unsignedInteger('school_year_id');
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
        Schema::dropIfExists('alumini_students');
    }
}
