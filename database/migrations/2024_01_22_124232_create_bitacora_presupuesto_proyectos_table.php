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
        Schema::create('bitacora_presupuesto_proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyecto');
            $table->foreignId('id_user');
            $table->float('campo');
            $table->string('descripcion');
            $table->float('original');
            $table->float('diferencia');
            $table->float('nuevo');
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
        Schema::dropIfExists('bitacora_presupuesto_proyectos');
    }
};
