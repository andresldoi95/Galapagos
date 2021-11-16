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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->char('es_superadmin', 1)->default('N');
            $table->char('estado', 1)->default('A');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('creador_id')->nullable();
            $table->unsignedBigInteger('modificador_id')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('creador_id')->references('id')->on('users');
            $table->foreign('modificador_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
