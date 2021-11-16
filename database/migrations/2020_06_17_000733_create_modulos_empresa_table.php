<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos_empresa', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id');
            $table->string('modulo_id', 10);
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('modulo_id')->references('id')->on('modulos');
            $table->primary([
                'empresa_id', 'modulo_id'
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
        Schema::dropIfExists('modulos_empresa');
    }
}
