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
            'preco' =>'required|unique:servicos',
            'data_servico'=>'required|unique:servicos',
            'categoria'=>'required|unique:servicos',
            'hora_saida'=>'required|unique:servicos',
            'tipo_pagamento'=>'required|unique:servicos',
            'id_cliente'=>'required|unique:servicos',
            'id_tipo_servico'=>'required|unique:servicos',
            'id_veiculo'=>'required|unique:servicos',
        ];
    }
}
