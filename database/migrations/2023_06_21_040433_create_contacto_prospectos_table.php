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
        Schema::create('contacto_prospectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospecto_id');
            $table->string('nombre');
            $table->string('posicion');
            $table->string('area');
            $table->string('correo1');
            $table->string('correo2')->nullable();
            $table->string('correo3')->nullable();
            $table->string('telefono1');
            $table->string('telefono2')->nullable();
            $table->string('telefono3')->nullable();
            $table->text('notas')->nullable();
            $table->integer('estatus')->default(1);
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
        Schema::dropIfExists('contacto_prospectos');
    }
};
