<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers\Api
 */
class UsersController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::paginate(30));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
}
