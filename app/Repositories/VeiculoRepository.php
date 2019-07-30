<?php


namespace App\Repositories;


use App\Models\Veiculo;
use Illuminate\Validation\ValidationException;

class VeiculoRepository
{

    protected $veiculo;

    public function __construct(Veiculo $model)
    {
        $this->veiculo = $model;
    }

    public function getResults($modelo = null)
    {
        return $this->veiculo->where('modelo', 'LIKE',"%{$modelo}%")->get();
    }

    public function buscarVeiculoporPlaca($placa)
    {
        return $this->veiculo->with(['cliente'])->where('placa', '=',$placa)->first();

    }
    public function getAll()
    {
        return $this->veiculo->with(['tipoVeiculo', 'cliente'])->get();
    }

    public function findOrFail($id = null)
    {
        $veiculo = $this->veiculo->find($id);

        if (!$veiculo) {
            throw ValidationException::withMessages(['msg' => ' Veiculo não encontrado']);
        }

        return $veiculo;
    }


    public function delete(Veiculo $veiculo)
    {
        return $veiculo->delete();
    }
}
