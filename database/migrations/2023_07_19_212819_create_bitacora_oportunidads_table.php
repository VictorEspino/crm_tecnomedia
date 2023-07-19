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
        Schema::create('bitacora_oportunidads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oportunidad_id');
            $table->foreignId('tipo_id');
            $table->text('detalles');
            $table->float('gasto');
            $table->string('concepto gasto');
            $table->foreignId('autorizador_id');
            $table->integer('estatus_autorizacion')->default(0); //1 autorizado, 2 rechazado
            $table->datetime('autorizacion');
            $table->date('due_date');
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
        Schema::dropIfExists('bitacora_oportunidads');
    }
};
