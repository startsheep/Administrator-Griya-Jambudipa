<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware(['guest']);
    }

    public function __invoke(LoginRequest $request, UserRepository $userRepository)
    {
        $user = $userRepository->findByCriteria([['email', '=', $request->email]]);

        if (!$user) {
            return response()->json([
                'message' => 'wrong email or password!'
            ], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'wrong email or password!'
            ], 400);
        }

        $role = str_replace(' ', '_', strtolower('Auth'));

        $token = $user->createToken('api', [$role]);

        Auth::login($user);

        return response()->json([
            'message' => 'Login success!',
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role
                ],
                'token' => $token->plainTextToken
            ]
        ]);
    }
}
