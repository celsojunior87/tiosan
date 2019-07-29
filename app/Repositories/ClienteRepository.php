<?php

namespace App\Repositories;

use App\Models\Cliente;

use Illuminate\Validation\ValidationException;

class ClienteRepository
{
    protected $cliente;

    public function __construct(Cliente $model)
    {
        $this->cliente = $model;
    }

    public function getResults($nome = null)
    {
        return $this->cliente->where('nome', 'LIKE',"%{$nome}%")->get();
    }

    public function findOrFail($id = null)
    {
        $cliente = $this->cliente->find($id);

        if (!$cliente) {
            throw ValidationException::withMessages(['msg' => 'Cliente não encontrado']);
        }

        return $cliente;
    }
    public function delete(Cliente $cliente)
    {
        return $cliente->delete();
    }

}
