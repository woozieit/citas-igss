<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_id')->constrained('clinicas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedSmallInteger('dia_semana');
            $table->boolean('estado')->default(false);

            $table->time('manana_inicio');
            $table->time('manana_fin');

            $table->time('tarde_inicio');
            $table->time('tarde_fin');
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
        Schema::dropIfExists('horarios');
    }
}
