<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->unsignedInteger('school_year_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('order')->default(1);
	        $table->unsignedInteger('level_of_adm')->default(null)->nullable();
	        $table->unsignedInteger('dormitory_id')->default(null)->nullable();
	        $table->unsignedInteger('student_group_id')->default(null)->nullable();
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
        Schema::dropIfExists('applicants');
    }
}
