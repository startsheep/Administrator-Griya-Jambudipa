<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\LogContract;
use App\Http\Resources\Log\LogCollection;
use App\Http\Resources\Log\LogDetail;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $logRepository;

    public function __construct(LogContract $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function index(Request $request)
    {
        $result = $this->logRepository->all($request);

        return new LogCollection($result);
    }

    public function show($id)
    {
        $result = $this->logRepository->find($id);

        return new LogDetail($result);
    }
}
