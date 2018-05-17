<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttachmentIntoMail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('messages', function (Blueprint $table) {
		    $table->string('attachment')->nullable()->default(null)->after('message');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('messages', function (Blueprint $table) {
		    $table->dropColumn('attachment');
	    });
    }
}
