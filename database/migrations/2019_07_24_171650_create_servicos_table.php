<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('preco');
            $table->string('preco_adc')->nullable();
            $table->date('data_servico');
            $table->time('hora_entrada');
            $table->time('hora_saida')->nullable();
            $table->string('tipo_pagamento');
            $table->string('categoria');
            $table->text('obs_adicionais')->nullable();
            $table->text('obs_avarias')->nullable();
            $table->timestamps();


            $table->unsignedInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('clientes');

            $table->unsignedInteger('id_tipo_servico');
            $table->foreign('id_tipo_servico')->references('id')->on('tipo_servicos');

            $table->unsignedInteger('id_veiculo');
            $table->foreign('id_veiculo')->references('id')->on('veiculos');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicos');
    }
}
