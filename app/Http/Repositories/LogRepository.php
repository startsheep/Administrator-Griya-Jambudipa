<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\LogContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\LogSearch;
use App\Models\Log;

class LogRepository implements LogContract
{
    /** @var Log */
    protected $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function all($request)
    {
        $factory = app()->make(LogSearch::class);
        $logs = $factory->apply()->paginate($request->per_page);

        return $logs;
    }

    public function find($id)
    {
        $result = $this->log->findOrFail($id);

        return $result;
    }
}
