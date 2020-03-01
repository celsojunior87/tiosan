<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'preco' =>'required:servicos',
            'data_servico'=>'required:servicos',
            'categoria'=>'required:servicos',
            'hora_entrada'=>'required:servicos',
            'tipo_pagamento'=>'required:servicos',
            'funcionario'=>'required:servicos',
            'id_cliente'=>'required:servicos',
            'id_tipo_servico'=>'required:servicos',
            'id_veiculo'=>'required:servicos',
        ];
    }
}
