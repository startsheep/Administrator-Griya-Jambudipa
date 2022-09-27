<?php

namespace App\Http\Services\Searches\Filters\Log;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Search implements FilterContract
{
    /** @var string|null */
    protected $search;

    /**
     * @param string|null $search
     * @return void
     */
    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $query->when($search = $this->search, function ($query) use ($search) {
            $query->whereHas('user', function ($queryUser) use ($search) {
                $queryUser->where('email', 'LIKE', '%' . $search . '%');
            });
        });

        return $next($query);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->search) {
            return $this->search;
        }

        $this->search = request('search', null);

        return request('search');
    }
}
