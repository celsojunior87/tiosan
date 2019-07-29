<?php

namespace App\Repositories;

use App\User;
use Illuminate\Validation\ValidationException;

class UserRepository
{
    protected $user;

    public function __construct(User $model)
    {
        $this->user = $model;
    }

    public function findOrFail(int $id) :User
    {
        $user = $this->user->with(['empresa'])->where(['id' => $id])->firstOrFail();
        if (! $user) {
            throw ValidationException::withMessages(['msg' => ' Usuário não encontrado']);
        }
        return $user;
    }

    public function findOrFailByEmail(string $email) :User
    {
        $user = $this->user->with(['empresa'])->where(['email' => $email])->firstOrFail();
        if (! $user) {
            throw ValidationException::withMessages(['msg' => ' Usuário não encontrado']);
        }
        return $user;
    }

    public function existByEmail($email)
    {
        return $this->user->where(['email' => $email])->exists();
    }
}
