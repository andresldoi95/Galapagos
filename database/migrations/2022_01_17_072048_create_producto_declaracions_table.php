<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoDeclaracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('productos_declaracion'))
            Schema::create('productos_declaracion', function (Blueprint $table) {
                $table->char('declaracion_id', 36);
                $table->unsignedBigInteger('producto_id');
                $table->foreign('declaracion_id')->references('id')->on('declaraciones_juramentadas');
                $table->foreign('producto_id')->references('id')->on('productos');
                $table->primary(['declaracion_id', 'producto_id']);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_declaracion');
    }
}
