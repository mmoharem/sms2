<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
        	$table->increments('id');
        	$table->unsignedInteger('student_id');
        	$table->unsignedInteger('user_id');
        	$table->unsignedInteger('school_id');
        	$table->unsignedInteger('school_year_id');
        	$table->unsignedInteger('section_id');
        	$table->unsignedInteger('level_id')->nullable()->default(null);
        	$table->unsignedInteger('subject_id');
        	$table->unsignedInteger('semester_id')->nullable()->default(null);
        	$table->unsignedInteger('student_group_id')->nullable()->default(null);
        	$table->decimal('mid_sem', 50,2)->nullable()->default(null);
        	$table->decimal('credit', 50,2)->nullable()->default(null);
        	$table->string('grade')->nullable()->default(null);
        	$table->decimal('exams', 50,2)->nullable()->default(null);
        	$table->unsignedInteger('exam_score')->nullable()->default(null);
        	$table->text('remarks')->nullable()->default(null);
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
        Schema::dropIfExists('registrations');
    }
}
