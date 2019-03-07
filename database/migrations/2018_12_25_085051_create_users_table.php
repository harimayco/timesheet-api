<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('av_user', function (Blueprint $table) {
            //$table->increments('id');
            // $table->string('email')->unique();
            //$table->string('name');
            //$table->string('passwd');
            $table->dateTime('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('av_user', function (Blueprint $table) {
            $table->dropColumn('passwd');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
