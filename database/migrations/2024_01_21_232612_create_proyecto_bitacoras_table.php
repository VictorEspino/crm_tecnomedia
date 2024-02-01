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
        Schema::create('proyecto_bitacoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_consultor_id');
            $table->foreignId('user_carga_id');
            $table->float('horas');
            $table->string('actividad');
            $table->foreignId('actividad_tipo_id');
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
        Schema::dropIfExists('proyecto_bitacoras');
    }
};
