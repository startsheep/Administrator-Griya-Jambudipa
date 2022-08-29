<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function auth()
    {
        return view('auth');
    }
    // ini juga dipake
    public function auth5()
    {
        return view('auth');
    }
}
