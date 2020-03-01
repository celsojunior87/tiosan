<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVeiculo extends Model
{

    public $timestamps = false;
    protected $table = 'tipo_veiculos';

    protected $fillable = ['nome'];
}
