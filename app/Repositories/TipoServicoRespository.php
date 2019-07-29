<?php

namespace App\Repositories;


use App\Models\TipoServico;

class TipoServicoRespository
{

    protected $tipoServico;

    public function __construct(TipoServico $model)
    {
        $this->tipoServico = $model;
    }

    public function getResults($tiposervico = null)
    {
        return $this->tipoServico->where('tipo_servico','LIKE',"%{$tiposervico}%")->get();
    }

}
