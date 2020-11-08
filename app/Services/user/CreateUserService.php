<?php

namespace App\Services\user;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CreateUserService
{
    public function create(array $data)
    {
        $this->checkUserExistence($data['username']);

        return User::create(['username' => $data['username']]);
    }

    private function checkUserExistence(string $username)
    {
        if (User::where('username', $username)->exists()) {
            abort(Response::HTTP_FORBIDDEN, 'This username is taken');
        }
    }
}
