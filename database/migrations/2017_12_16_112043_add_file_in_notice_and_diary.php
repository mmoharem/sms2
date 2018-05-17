<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileInNoticeAndDiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diaries', function (Blueprint $table) {
            $table->string('file')->nullable()->default(null)->after('description');
        });

        Schema::table('notices', function (Blueprint $table) {
            $table->string('file')->nullable()->default(null)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diaries', function (Blueprint $table) {
            $table->dropColumn('file');
        });

        Schema::table('notices', function (Blueprint $table) {
            $table->dropColumn('file');
        });
    }
}
