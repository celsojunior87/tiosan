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
        return $this->servico->with(['veiculo', 'cliente','tipoVeiculo'])->get();
    }

    public function findOrFail($id = null)
    {
        $servico = $this->servico->find($id);

        if (!$servico) {
            throw ValidationException::withMessages(['msg' => ' Serviço não encontrado']);
        }

        return $servico;
    }


    public function delete(Servico $servico)
    {
        return $servico->delete();
    }

    public function salvarImagemServico($request)
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = kebab_case($request->name);
            $extension = $request->image->extension();

            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile);

            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
        }
    }

}
