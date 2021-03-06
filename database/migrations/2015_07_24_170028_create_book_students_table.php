<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookStudentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_students', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('book_id');
            $table->foreign('book_id', 'fk_book_students_books1')->references('id')->on('books')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('student_id');
            $table->foreign('student_id', 'fk_book_students_students1')->references('id')->on('students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->date('reserved')->nullable();
            $table->date('get')->nullable();
            $table->date('back')->nullable();
            $table->text('note')->nullable();
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
        Schema::table('book_students', function (Blueprint $table) {
            $table->dropForeign('fk_book_students_books1');
            $table->dropForeign('fk_book_students_students1');
        });
        Schema::drop('book_students');
    }

}
