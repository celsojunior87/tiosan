<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
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
            'marca' =>'required:veiculos',
            'modelo' =>'required:veiculos',
            'ano' =>'required:veiculos',
            'placa' =>"required|unique:veiculos,placa,{$this->segment('3')},id",
            'cor' =>'required:veiculos',
            'id_cliente' => 'required',
            'id_tipo_veiculo' => 'required',

        ];
    }
}
