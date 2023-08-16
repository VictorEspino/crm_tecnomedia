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
        Schema::create('cotizacion_seccion_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seccion_id');
            $table->float('cantidad');
            $table->string('descripcion');
            $table->string('unidad');
            $table->float('unitario');
            $table->float('descuento');
            $table->float('p_final');
            $table->float('a1');
            $table->float('a2');
            $table->float('a3');
            $table->float('a4');
            $table->float('a5');
                                
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
        Schema::dropIfExists('cotizacion_seccion_items');
    }
};
