<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseStudentAndSubjectOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('students', function (Blueprint $table) {
		    $table->integer('order')->change();
	    });
	    Schema::table('subjects', function (Blueprint $table) {
		    $table->integer('order')->change();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('students', function (Blueprint $table) {
		    $table->boolean('order')->change();
	    });
	    Schema::table('subjects', function (Blueprint $table) {
		    $table->boolean('order')->change();
	    });
    }
}
