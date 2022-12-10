<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\UserRepository;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware(['guest']);
        $this->userRepository = $userRepository;
    }

    public function __invoke(RegisterRequest $request)
    {
        $result = $this->userRepository->create($request->all());

        return response()->json([
            'message' => 'Register success!',
            'result' => $result
        ]);
    }
}
