<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombres_apellidos');
            $table->string('dpi', 13)->unique();
            $table->string('correo')->unique();
            $table->text('direccion')->nullable();
            $table->enum('rol', ['Admin', 'Afiliado']);
            $table->string('telefono')->nullable();
            $table->boolean('acreditacion')->default(true);
            $table->string('password');
            //$table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
