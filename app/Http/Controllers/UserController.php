<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPost;
use App\Http\Resources\UserResource;
use App\Services\user\CreateUserService;

class UserController extends Controller
{
    public function store(UserPost $request, CreateUserService $createUserService)
    {
        $user = $createUserService->create($request->all());

        return new UserResource($user);
    }
}
