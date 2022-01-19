<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoRetenidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('productos_retenidos'))
            Schema::create('productos_retenidos', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->char('retencion_id', 36);
                $table->unsignedBigInteger('producto_id');
                $table->decimal('cantidad', 15, 6);
                $table->decimal('peso', 10, 2);
                $table->string('categoria', 2);
                $table->string('razon_retencion', 2);
                $table->string('destino_producto', 6);
                $table->string('transportado_en', 3);
                $table->timestamps();
                $table->foreign('retencion_id')->references('id')->on('registro_retenciones');
                $table->foreign('producto_id')->references('id')->on('productos');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_retenidos');
    }
}
