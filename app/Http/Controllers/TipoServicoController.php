<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoServicoRequest;
use App\Models\TipoServico;
use App\Repositories\TipoServicoRespository;
use Illuminate\Http\Request;

class TipoServicoController extends Controller
{
    protected $repository;
    protected $tipoServico;

    public function __construct(TipoServicoRespository $tipoServicoRepository, TipoServico $model)
    {
        $this->repository = $tipoServicoRepository;
        $this->tipoServico = $model;
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
    public function store(TipoServicoRequest $request)
    {
        $tipoServico = $this->tipoServico->create($request->all());
        return response()->json($tipoServico);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoServico = $this->tipoServico->find($id);
        return response()->json($tipoServico);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoServicoRequest $request, $id)
    {
        if(!$tipoServico = $this->tipoServico->find($id))
            return response()->json('error','Not Found');

        $tipoServico->update($request->all());

        return response()->json(['success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoServico = $this->repository->findOrFail($id);
        $this->repository->delete($tipoServico, $id);
        return $this->success(['msg' => 'Excluído']);
    }
}
