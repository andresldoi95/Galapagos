<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroRetencionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('registro_retenciones'))
            Schema::create('registro_retenciones', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->unsignedBigInteger('empresa_id');
                $table->string('lugar', 2)->nullable();
                $table->string('tipo_transporte', 2);
                $table->string('nombre_transporte', 500);
                $table->string('destino');
                $table->string('procedencia');
                $table->string('numero_documento', 8)->unique();
                $table->dateTime('fecha');
                $table->char('retencion', 1)->default('N');
                $table->char('rechazo', 1)->default('N');
                $table->char('inspeccion_origen', 1)->default('N');
                $table->string('inspector_responsable')->nullable();
                $table->date('fecha_inspeccion')->nullable();
                $table->string('numero_guia_sanitaria', 50)->nullable();
                $table->string('numero_candado')->nullable();
                $table->string('nombre_completo', 500);
                $table->string('direccion');
                $table->string('numero_identificacion', 20);
                $table->char('tipo_residencia', 1)->default('N');
                $table->string('observaciones', 500)->nullable();
                $table->string('numero_guia_transporte', 50)->nullable();
                $table->decimal('porcentaje_mal_estado', 5, 2);
                $table->decimal('porcentaje_plagados', 5, 2);
                $table->char('retencion_patio', 1)->default('N');
                $table->string('nombre_inspector_responsable', 500);
                $table->string('identificacion_inspector_responsable', 20);
                $table->string('nombre_testigo', 500);
                $table->string('identificacion_testigo', 20);
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
        Schema::dropIfExists('registro_retenciones');
    }
}
