<?php

namespace App\Http\Services\Searches\Filters\WholeJob;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Type implements FilterContract
{
    /** @var string|null */
    protected $type;

    /**
     * @param string|null $type
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        $query->where('type', 'LIKE', '%' . $this->type . '%');

        return $next($query);
    }

    /**
     * Get type keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->type) {
            return $this->type;
        }

        $this->type = request('type', null);

        return request('type');
    }
}
