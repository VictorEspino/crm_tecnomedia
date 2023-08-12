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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignID('oportunidad_id');
            $table->date('fecha_presentacion');
            $table->string('descripcion');
            $table->float('total_propuesta');
            $table->foreignId('user_id');
            $table->foreignId('compania_id');
            $table->foreignId('moneda_id');
            $table->integer('anos');
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
        Schema::dropIfExists('cotizacions');
    }
};
