<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function __invoke(LoginRequest $request, UserRepository $userRepository)
    {
        $user = $userRepository->findByCriteria([['email', '=', $request->email]]);

        if (!$user) {
            return response()->json([
                'message' => 'email atau password salah!'
            ], 400);
        }

        if ($user->is_active != 1) {
            return response()->json([
                'message' => 'akun anda dinonaktifkan, hubungi admin!'
            ], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'email atau password salah!'
            ], 400);
        }

        $role = str_replace(' ', '_', strtolower('Auth'));

        $token = $user->createToken('api', [$role]);

        Auth::login($user);

        $image = $user->image()->where("documentable_type", 'App\Models\Account')
            ->where("documentable_id", $user->id)
            ->first();

        Log::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'description' => $user->name . ' login pada tanggal ' . Carbon::now()->isoFormat("D MMMM Y")
        ]);

        return response()->json([
            'message' => 'Login success!',
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'image' => $image,
                    'role' => $role
                ],
                'token' => $token->plainTextToken
            ]
        ]);
    }
}
