<?php

namespace App\Http\Services\Searches\Filters\Kavling;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Block implements FilterContract
{
    /** @var string|null */
    protected $block;

    /**
     * @param string|null $block
     * @return void
     */
    public function __construct($block)
    {
        $this->block = $block;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        $query->where('block', 'LIKE', '%' . $this->block . '%');

        return $next($query);
    }

    /**
     * Get block keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->block) {
            return $this->block;
        }

        $this->block = request('block', null);

        return request('block');
    }
}
