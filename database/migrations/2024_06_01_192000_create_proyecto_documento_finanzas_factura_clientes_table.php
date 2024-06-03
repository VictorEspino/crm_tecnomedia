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
        Schema::create('proyecto_documento_finanzas_factura_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id');
            $table->foreignId('seccion_id');
            $table->foreignId('id_cliente');
            $table->string('folio_cfdi');
            $table->foreignId('moneda');
            $table->float('tipo_cambio');
            $table->float('cantidad_neta');
            $table->float('impuestos_trasladados');
            $table->float('impuestos_retenidos');
            $table->float('cantidad_bruta');
            $table->date('fecha_emision');
            $table->integer('dias_pago');
            $table->date('fecha_vencimiento');
            $table->string('cuenta_contable');
            $table->string('orden_compra');
            $table->integer('incluye_servicios');
            $table->integer('horas_servicio');
            $table->float('importe_neto_servicios');
            $table->string('notas')->nullable();
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
        Schema::dropIfExists('proyecto_documento_finanzas_factura_clientes');
    }
};
