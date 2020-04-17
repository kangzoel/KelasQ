<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserKlassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_klass', function (Blueprint $table) {
            $table->unsignedBigInteger('klass_id');
            $table->unsignedBigInteger('user_npm');
            $table->unsignedTinyInteger('role_id');

            $table->foreign('klass_id')->references('id')->on('klasses')->onDelete('cascade');
            $table->foreign('user_npm')->references('npm')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_klass');
    }
}
