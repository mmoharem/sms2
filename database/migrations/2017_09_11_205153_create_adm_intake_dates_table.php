<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmIntakeDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_intake_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_year_id');
            $table->timestamp('orientation');
            $table->timestamp('lecture_begin');
            $table->timestamp('registration_date');
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
        Schema::dropIfExists('adm_intake_dates');
    }
}
