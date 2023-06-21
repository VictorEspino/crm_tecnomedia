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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospecto_id');
            $table->foreignId('contacto_prospecto_id');
            $table->foreignId('linea_negocio_id');
            $table->foreignId('servicio_id');
            $table->string('oportunidad');
            $table->string('partner');
            $table->string('producto');
            $table->foreignId('etapa_id');
            $table->foreignId('fuente_id');
            $table->date('fecha_contacto');
            $table->text('comentarios')->nullable();
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
        Schema::dropIfExists('leads');
    }
};
