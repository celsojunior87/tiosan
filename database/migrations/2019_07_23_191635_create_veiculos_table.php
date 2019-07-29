<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('clientes');

            $table->unsignedInteger('id_tipo_veiculo');
            $table->foreign('id_tipo_veiculo')->references('id')->on('tipo_veiculos');

            $table->string('marca');
            $table->string('modelo');
            $table->integer('ano');
            $table->string('placa');
            $table->string('cor')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
}
