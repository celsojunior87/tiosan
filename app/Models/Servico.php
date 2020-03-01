<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servicos';

    protected $fillable = ['preco', 'adicionais', 'preco_adc', 'data_servico', 'hora_saida',
        'obs_adicionais', 'obs_avarias', 'hora_entrada',
        'categoria', 'funcionario',
        'tipo_pagamento', 'id_cliente', 'id_tipo_servico', 'id_veiculo'];

    public function veiculo()
    {
        return $this->hasOne(Veiculo::class, 'id', 'id_veiculo');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'id_cliente');
    }

    public function tipoServico()
    {
        return $this->hasOne(TipoServico::class, 'id', 'id_tipo_servico');
    }

}
