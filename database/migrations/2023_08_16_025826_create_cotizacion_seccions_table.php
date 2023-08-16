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
        Schema::create('cotizacion_seccions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id');
            $table->string('nombre');
            $table->float('t_a1');
            $table->float('t_a2');
            $table->float('t_a3');
            $table->float('t_a4');
            $table->float('t_a5');
            $table->float('total');
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
        Schema::dropIfExists('cotizacion_seccions');
    }
};
