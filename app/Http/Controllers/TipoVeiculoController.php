<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoVeiculoRequest;
use App\Models\TipoVeiculo;
use App\Repositories\TipoVeiculoRepository;
use Illuminate\Http\Request;

class TipoVeiculoController extends Controller
{
    protected $tipoVeiculo;
    protected $repository;

    public function __construct(TipoVeiculoRepository $tipoVeiculoRepository, TipoVeiculo $model)
    {
        $this->tipoVeiculo = $model;
        $this->repository = $tipoVeiculoRepository;

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
    public function store(TipoVeiculoRequest $request)
    {
        $tipoVeiculo = $this->tipoVeiculo->create($request->all());

        return response()->json($tipoVeiculo,201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoVeiculos = $this->tipoVeiculo->find($id);
        return response()->json($tipoVeiculos);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoVeiculoRequest $request, $id)
    {

        if(!$tipoVeiculo = $this->tipoVeiculo->find($id))
            return response()->json(['error' =>'Not found'],404);

        $tipoVeiculo->update($request->all());

        return response()->json($tipoVeiculo);
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
}
