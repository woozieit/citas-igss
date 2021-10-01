<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('clinica_id')->constrained('clinicas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');

            $table->date('fecha_cita');
            $table->time('hora_cita');

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
        Schema::dropIfExists('citas');
    }
}
