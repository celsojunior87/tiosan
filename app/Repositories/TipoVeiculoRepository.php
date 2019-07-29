<?php

namespace App\Repositories;


use App\Models\TipoVeiculo;
use Illuminate\Validation\ValidationException;

class TipoVeiculoRepository
{
    protected $tipoVeiculo;

    public function __construct(TipoVeiculo $model)
    {
        $this->tipoVeiculo = $model;
    }

    public function getAll()
    {
        return $this->tipoVeiculo->all();

    }
    public function getResults($nome = null)
    {
        return $this->tipoVeiculo->where('nome', 'LIKE',"%{$nome}%")->get();

    }


    public function findOrFail($id = null)
    {
        $tipoVeiculo = $this->tipoVeiculo->find($id);

        if (!$tipoVeiculo) {
            throw ValidationException::withMessages(['msg' => 'Tipo Veiculo não encontrado']);
        }

        return $tipoVeiculo;
    }


    public function delete(TipoVeiculo $tipoVeiculo)
    {
        return $tipoVeiculo->delete();
    }

}
