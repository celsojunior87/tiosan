<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = 'veiculos';

    public $timestamps = false;
    protected $fillable = ['nome','marca',
        'ano','modelo','id_tipo_veiculo','cor','placa','id_cliente'];

    public function tipoVeiculo()
    {
        return $this->hasOne(TipoVeiculo::class,'id','id_tipo_veiculo');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class,'id','id_cliente');
    }
}
