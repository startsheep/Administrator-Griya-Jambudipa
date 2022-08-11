<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response([
            'message' => 'logout success'
        ]);
    }
}
