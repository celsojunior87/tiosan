<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicoRequest;
use App\Models\Cliente;
use App\Models\Servico;
use App\Repositories\ClienteRepository;
use App\Repositories\ServicoRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
class ServicoController extends Controller
{
    protected $clienteRepository;
    protected $repository;
    protected $servico;

    public function __construct(ServicoRepository $repository, Servico $model, ClienteRepository $clienteRepository)
    {
        $this->repository = $repository;
        $this->clienteRepository = $clienteRepository;
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
        return $this->success(['msg' => 'Salvo e Enviado com sucesso']);
    }

    public function enviarEmailInicioServico($servico)
    {
        $servico = $this->repository->findOrFail($servico->id)->toArray();
        MAil::send('mail.start', $servico, function($message) use ($servico) {
            $message->to($servico['cliente']['email'], 'To Website')
                ->subject('Acabamos de registrar seu serviço no Lavajato Tio San');
            $message->from('lavajatotiosan@naoresponda','Lava Jato Tio San');
        });
    }

    public function enviarEmailFimServico($servico)
    {

        $servico = $this->repository->findOrFail($servico->id)->toArray();
        MAil::send('mail.end', $servico, function($message) use ($servico) {
            $message->to($servico['cliente']['email'], 'To Website')
                ->subject('Finalizamos seu Serviço no Lavajato Tio San');
            $message->from('lavajatotiosan@naoresponda','Lava Jato Tio San');
        });
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
    public function gerarRelatorio()
    {

        $data = ['title' => 'Welcome to HDTuto.com'];
        $pdf = PDF::loadView('pdf', $data);
        return $pdf->download('hdtuto.pdf');

//        $servicos = Servico::all();
//
//        return PDF::loadView('pdf', compact('servicos'))
//            // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
//            ->download('teste.pdf');
    }
}
