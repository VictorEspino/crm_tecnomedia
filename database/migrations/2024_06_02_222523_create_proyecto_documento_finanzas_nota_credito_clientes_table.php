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
        Schema::create('proyecto_documento_finanzas_nota_credito_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id');
            $table->string('folio');
            $table->date('f_emision');
            $table->float('cantidad');
            $table->string('notas');
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
        Schema::dropIfExists('proyecto_documento_finanzas_nota_credito_clientes');
    }
};
