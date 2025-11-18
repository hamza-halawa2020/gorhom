<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;

class UserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $users = User::all();

        return $this->success(UserResource::collection($users));
    }

    public function show(User $user)
    {
        return $this->success(new UserResource($user));
    }

    public function store(StoreUserRequest $request, User $user)
    {
        $user = User::create($request->validated());

        return $this->success(new UserResource($user), 'User created', 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return $this->success(new UserResource($user), 'User updated');
    }

    // delete user
    public function destroy(User $user)
    {
        $user->delete();
        return $this->success(null, 'User deleted', 204);
    }
}
