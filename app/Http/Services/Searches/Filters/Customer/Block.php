<?php

namespace App\Http\Services\Searches\Filters\Customer;

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
        $query->when($block = $this->block, function ($q) use ($block) {
            $q->whereHas('kavling', function ($kavlingQuery) use ($block) {
                $kavlingQuery->where('block', 'LIKE', '%' . $block . '%');
            });
        });

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
