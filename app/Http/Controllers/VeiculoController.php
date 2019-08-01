<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeiculoRequest;
use App\Models\Veiculo;
use App\Repositories\VeiculoRepository;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    protected $repository;
    protected $veiculo;

    public function __construct(VeiculoRepository $repository, Veiculo $model)
    {
        $this->repository = $repository;
        $this->veiculo = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->ok($this->repository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VeiculoRequest $request)
    {
        $veiculo = $this->veiculo->create($request->all());
        if(!$veiculo['placa'])
            return $this->error(['msg'=>'A Placa ja existe Na Base de dados']);
        return response()->json($veiculo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veiculo = $this->veiculo->find($id);
        return response()->json($veiculo);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VeiculoRequest $request, $id)
    {
        if(!$veiculo = $this->veiculo->find($id))
            return response()->json(['errror' => 'Not Found'],404);
        $veiculo->update($request->all());
        return response()->json($veiculo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoVeiculo = $this->repository->findOrFail($id);
        $this->repository->delete($tipoVeiculo,$id);
        return $this->success(['msg'=>'Excluido']);
    }

    public function buscarClientePorPlaca($placa)
    {
       $veiculo = $this->repository->buscarVeiculoporPlaca($placa);

       if(!$veiculo)
           return $this->error(['msg'=>'Não Existe Esse Cliente, Por favor Cadastre novamente o cliente ou 
           o Veiculo']);
       return response()->json($veiculo);

    }
}
