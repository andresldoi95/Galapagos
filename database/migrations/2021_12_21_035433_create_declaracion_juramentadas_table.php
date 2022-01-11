<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclaracionJuramentadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('declaraciones_juramentadas')) {
            Schema::create('declaraciones_juramentadas', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->string('codigo', 20)->unique();
                $table->string('apellidos');
                $table->string('nombres');
                $table->string('numero_identificacion', 20);
                $table->string('telefono', 100)->nullable();
                $table->string('correo_electronico', 500)->nullable();
                $table->string('lugar_residencia');
                $table->string('nacionalidad');
                $table->string('direccion_domicilio', 300);
                $table->string('linea_aerea');
                $table->string('numero_vuelo', 50);
                $table->string('aeropuerto_origen');
                $table->char('alimentos_procesados', 1)->default('N');
                $table->char('lugares_concentracion', 1)->default('N');
                $table->char('equipos_campamento', 1)->default('N');
                $table->date('fecha');
                $table->char('estado', 1)->default('A');
                $table->unsignedBigInteger('usuario_id')->nullable();
                $table->timestamps();
                $table->foreign('usuario_id')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declaraciones_juramentadas');
    }
}
