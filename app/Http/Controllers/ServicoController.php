<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicoRequest;
use App\Models\Servico;
use App\Repositories\ServicoRepository;
use Illuminate\Support\Facades\Mail;

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
        $servico = $this->repository->create($request->all());
        $this->enviarEmailInicioServico($servico);
        return $this->success(['msg' => 'Salvo com sucesso']);

    }

    public function enviarEmailInicioServico($servico)
    {
        $servico = $this->repository->findOrFail($servico->id)->toArray();
        MAil::send('mail.start', $servico, function($message) use ($servico) {
            $message->to($servico['cliente']['email'], 'To Website')
                ->subject('Acabamos de registrar seu serviço no Lavajato Tio San');
            $message->from('lavajatotiosan@naoresponda','From Visitor');
        });
    }

    public function enviarEmailFimServico($servico)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->ok($this->repository->findOrFail($id));
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
        $servico = $this->repository->findOrFail($id);
        $this->repository->update($servico, $request->all());
        return $this->success(['msg' => 'Atualizado com sucesso']);
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
