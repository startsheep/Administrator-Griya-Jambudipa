<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        Log::create([
            'id' => Str::uuid()->toString(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' keluar dari aplikasi'
        ]);

        return response([
            'message' => 'logout success'
        ]);
    }
}
