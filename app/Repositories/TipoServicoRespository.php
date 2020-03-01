<?php

namespace App\Repositories;


use App\Models\TipoServico;
use Illuminate\Validation\ValidationException;

class TipoServicoRespository
{

    protected $tipoServico;

    public function __construct(TipoServico $model)
    {
        $this->tipoServico = $model;
    }

    public function getAll()
    {
        return $this->tipoServico->all();
    }

    public function getResults($tiposervico = null)
    {
        return $this->tipoServico->where('tipo_servico','LIKE',"%{$tiposervico}%")->get();
    }

    public function findOrFail($id = null)
    {
        $tipoServico = $this->tipoServico->find($id);

        if (!$tipoServico) {
            throw ValidationException::withMessages(['msg' => ' Veiculo não encontrado']);
        }

        return $tipoServico;
    }


    public function delete(TipoServico $tipoServico)
    {
        return $tipoServico->delete();
    }

}
