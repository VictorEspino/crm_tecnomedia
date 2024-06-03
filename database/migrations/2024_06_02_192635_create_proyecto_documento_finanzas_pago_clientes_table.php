<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_documento_finanzas_pago_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id');
            $table->foreignId('moneda');
            $table->float('tipo_cambio_pago');
            $table->float('tipo_cambio_efectivo');
            $table->float('cantidad_pago');
            $table->string('complemento_pago');
            $table->string('banco_pago');
            $table->string('tipo_pago');
            $table->date('f_pago');
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
        Schema::dropIfExists('proyecto_documento_finanzas_pago_clientes');
    }
};
