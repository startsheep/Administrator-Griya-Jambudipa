<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Log\LogRepository;
use App\Http\Resources\Log\LogCollection;
use App\Http\Resources\Log\LogDetail;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $logRepository;

    public function __construct(LogRepository $logRepository)
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
        $result = $this->logRepository->findOrFail($id);

        return new LogDetail($result);
    }
}
