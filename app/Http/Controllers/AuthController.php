<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function __invoke()
    {
        return view('pages.auth.v-login');
    }
}
