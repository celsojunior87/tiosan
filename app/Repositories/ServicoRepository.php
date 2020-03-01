<?php

namespace App\Repositories;


use App\Http\Requests\ServicoRequest;
use App\Models\FotoServico;
use App\Models\Servico;
use Illuminate\Validation\ValidationException;

class ServicoRepository
{

    protected $servico;

    public function __construct(Servico $model)
    {
        $this->servico = $model;
    }

    public function getAll()
    {
        return $this->servico->with(['veiculo', 'cliente', 'tipoServico'])->get();
    }

    public function findOrFail($id = null)
    {
        $servico = $this->servico->with(['veiculo', 'cliente', 'tipoServico'])->find($id);

        if (!$servico) {
            throw ValidationException::withMessages(['msg' => ' Serviço não encontrado']);
        }

        return $servico;
    }

    public function create($params)
    {
        return $this->servico::create($this->formatParams($params));
    }

    private function formatParams($params)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $formatted = [
            'preco' => $params['preco'] ?: 0,
            'data_servico' => isset($params['data_servico']) ? $params['data_servico'] : null,
            'hora_entrada' => isset($params['hora_entrada']) ? $params['hora_entrada'] : null,
            'hora_saida' => isset($params['hora_saida']) ? $params['hora_saida'] : null,
            'obs_adicionais' => isset($params['obs_adicionais']) ? $params['obs_adicionais'] : null,
            'preco_adc' => isset($params['preco_adc']) ? $params['preco_adc'] : null,
            'tipo_pagamento' => isset($params['tipo_pagamento']) ? $params['tipo_pagamento'] : null,
            'categoria' => isset($params['categoria']) ? $params['categoria'] : null,
            'funcionario' => isset($params['funcionario']) ? $params['funcionario'] : null,
//            'image' => isset($params['image']) ? $params['image'] : null,
            'id_tipo_servico' => $params['id_tipo_servico'],
            'id_veiculo' => $params['id_veiculo'],
            'id_cliente' => $params['id_cliente'],
        ];

        return $formatted;
    }

    public function update(Servico $servico, $params = array())
    {
        $servico->forceFill($this->formatParams($params))->save();
        return $servico;
    }


    public function delete(Servico $servico)
    {
        return $servico->delete();
    }

//    public function salvarImagemServico(ServicoRequest $request)
//    {
//        $data = $request->all();
//        if($request->hasFile('image')&& $request->file('image')->isValid()){
//            $name = $request->id_veiculo;
//            $extension = $request->image->extension();
//            $nameFile = "{$name}.{$extension}";
//            $data['image'] = $nameFile;
//            $upload = $request->image->storeAs($this->path,$nameFile);
//            if(!$upload)
//                return response()->json(['error' => 'Fail_Upload'],500);
//        }
//        $product = $this->product->create($data);
//        return response()->json($product,201);
//    }
}

