<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'role' => "Auth"
        ]);
    }
}
