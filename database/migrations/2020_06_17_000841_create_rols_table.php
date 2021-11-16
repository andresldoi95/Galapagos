<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->string('nombre');
            $table->string('descripcion', 500);
            $table->char('estado', 1)->default('A');
            $table->timestamps();
            $table->unsignedBigInteger('creador_id')->nullable();
            $table->unsignedBigInteger('modificador_id')->nullable();
            $table->foreign('creador_id')->references('id')->on('users');
            $table->foreign('modificador_id')->references('id')->on('users');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
