<?php

namespace App\Http\Services\Searches\Filters\Employee;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Active implements FilterContract
{
    /** @var string|null */
    protected $active;

    /**
     * @param string|null $active
     * @return void
     */
    public function __construct($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        $query->where('is_active', $this->active);

        return $next($query);
    }

    /**
     * Get active keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->active) {
            return $this->active;
        }

        $this->active = request('active', null);

        return request('active');
    }
}
