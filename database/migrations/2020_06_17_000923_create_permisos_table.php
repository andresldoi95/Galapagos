<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->unsignedBigInteger('rol_id');
            $table->string('accion_id', 60);
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->foreign('accion_id')->references('id')->on('acciones');
            $table->primary([
                'rol_id', 'accion_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
