<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    public $timestamps = false;
    protected $table ='tipo_servicos';
    protected $fillable = ['tipo_servico'];
}
