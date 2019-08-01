<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'nome' => "required:clientes",
            'telefone' => "required|unique:clientes,telefone,{$this->segment('3')},id",
            'email' => "required|unique:clientes,email,{$this->segment('3')},id",

        ];
    }
}
