<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function auth()
    {
        $user = Auth::user();
        return $this->repository->findOrFail($user->getAuthIdentifier());
    }

    public function show($id)
    {
        return $this->ok($this->repository->findOrFail($id));
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        if(empty($email)){
            return $this->error(['msg' => 'E-mail é obrigatório']);
        }

        $user = $this->repository->existByEmail($email);

        if($user) {
            return $this->ok(['msg' => 'E-mail existe', 'user' => $this->repository->findOrFailByEmail($email)]);
        }

        return $this->error(['msg' => 'E-mail não existe na base de dados'], 412);
    }
}
