<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicoRequest;
use App\Models\Servico;
use App\Repositories\ServicoRepository;

class ServicoController extends Controller
{
    protected $repository;
    protected $servico;

    public function __construct(ServicoRepository $repository, Servico $model)
    {
        $this->repository = $repository;
        $this->servico = $model;
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
    public function store(ServicoRequest $request)
    {
        $this->repository->create($request->all());
        return $this->success(['msg' => 'Salvo com sucesso']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servico = $this->servico->find($id);
        return response()->json($servico);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServicoRequest $request, $id)
    {

        if(!$servico = $this->servico->find($id))
            return response()->json('error','Not Found');

        $servico->update($request->all());

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
        $servico = $this->repository->findOrFail($id);
        $this->repository->delete($servico, $id);
        return $this->success(['msg' => 'Excluído']);
    }
}
