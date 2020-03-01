<?php

namespace App\Traits;

use App\Scopes\EmpresaScope;

trait EmpresaScopeTrait {

    /**
     * Boot the scope.
     *
     * @return void
     */
    public static function bootEmpresaScopeTrait()
    {
        static::addGlobalScope(new EmpresaScope());
    }
}
