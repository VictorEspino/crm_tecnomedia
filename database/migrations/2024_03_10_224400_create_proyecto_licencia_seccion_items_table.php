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
        Schema::create('proyecto_licencia_seccion_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seccion_id');
            $table->string('tipo');
            $table->string('descripcion');
            $table->float('cantidad');
            $table->float('unitario_cliente');
            $table->float('total_cliente');
            $table->float('unitario_tecnomedia');
            $table->float('total_tecnomedia');
            $table->foreignId('partner_id');
            $table->float('margen');
            $table->float('porcentaje_margen');
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
        Schema::dropIfExists('proyecto_licencia_seccion_items');
    }
};
