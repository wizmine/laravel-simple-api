<?php

namespace App\Http\Controllers;

use App\Facades\UserFacade;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit');

        return UserResource::collection(UserFacade::index($offset, $limit));
    }

    public function store(StoreUserRequest $request)
    {
        $user = UserFacade::store($request);
        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (!Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'message' => 'Wrong login or password',
            ], 401);
        }

        $user = Auth::guard('web')->user();
        /** @var \Laravel\Sanctum\NewAccessToken $token */
        $token = $user->createToken('login');

        $user->update(['api_token' => $token]);

        return ['token' => $token->plainTextToken];
    }
}
