<?php

namespace App\Http\Services\Searches\Filters\Log;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Sort implements FilterContract
{
    /** @var string|null */
    protected $sort;

    /**
     * @param string|null $sort
     * @return void
     */
    public function __construct($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        $query->orderBy('created_at', 'desc');

        return $next($query);
    }

    /**
     * Get sort keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->sort) {
            return $this->sort;
        }

        $this->sort = request('sort', null);

        return request('sort');
    }
}
