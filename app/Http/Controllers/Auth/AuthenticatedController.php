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
        $image = $user->image()->where("documentable_type", 'App\Models\Account')
            ->where("documentable_id", $user->id)
            ->first();

        return response()->json([
            'user' => $user,
            'image' => $image,
            'role' => "Auth"
        ]);
    }
}
