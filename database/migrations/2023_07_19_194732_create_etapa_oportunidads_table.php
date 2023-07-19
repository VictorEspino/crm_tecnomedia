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
        Schema::create('etapa_oportunidads', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->integer('visible')->default(1);
            $table->string("mensaje");
            $table->integer("dias");
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
        Schema::dropIfExists('etapa_oportunidads');
    }
};
