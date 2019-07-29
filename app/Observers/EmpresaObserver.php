<?php

namespace App\Observers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Auth;

class EmpresaObserver
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

    public function creating($model)
    {
        if(!isset($model->id_empresa) || empty($model->id_empresa)) {
            $model->id_empresa = $this->user->id_empresa;
        }
    }
}
