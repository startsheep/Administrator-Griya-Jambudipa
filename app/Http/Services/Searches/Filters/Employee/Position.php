<?php

namespace App\Http\Services\Searches\Filters\Employee;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Position implements FilterContract
{
    /** @var string|null */
    protected $position;

    /**
     * @param string|null $position
     * @return void
     */
    public function __construct($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $query->when($position = $this->position, function ($q)  use ($position) {
            $q->whereHas('position', function ($positionQuery) use ($position) {
                $positionQuery->where('name', 'like', '%' . $position . '%');
            });
        });


        return $next($query);
    }

    /**
     * Get position keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->position) {
            return $this->position;
        }

        $this->position = request('position', null);

        return request('position');
    }
}
