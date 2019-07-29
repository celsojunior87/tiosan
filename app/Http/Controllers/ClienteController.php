<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $cliente;
    protected $repository;

    public function __construct(ClienteRepository $clienteRepository, Cliente $model)
    {
        $this->repository = $clienteRepository;
        $this->cliente = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clientes = $this->repository->getResults($request->nome);
        return response()->json($clientes);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
        $clientes = $this->cliente->create($request->all());
        return response()->json($clientes, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$clientes = $this->cliente->find($id))
            return response()->json(['error' =>'Not found'],404);

        return response()->json($clientes);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, $id)
    {
        if(!$clientes = $this->cliente->find($id))
            return response()->json(['error' =>'Not found'],404);
        $clientes->update($request->all());
        return response()->json($clientes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->repository->findOrFail($id);
        $this->repository->delete($cliente,$id);
        return $this->success(['msg'=>'Excluido']);
    }
}
