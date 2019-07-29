<?php

namespace App\Scopes;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class EmpresaScope implements Scope
{
    protected $user;
    protected $userRepository;

    public function __construct()
    {
        $user = Auth::user();
        if(!$user){
            return;
        }
        $userRepository = new UserRepository(new User());
        $this->user = $userRepository->findOrFail($user->getAuthIdentifier());
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('id_empresa', '=', $this->user->id_empresa);
    }
}
