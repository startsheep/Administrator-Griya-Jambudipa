<?php

namespace App\Http\Services\Searches\Filters\Kavling;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Sold implements FilterContract
{
    /** @var string|null */
    protected $sold;

    /**
     * @param string|null $sold
     * @return void
     */
    public function __construct($sold)
    {
        $this->sold = $sold;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        // if sold is true, only show kavling that is related to customer
        if ($this->sold == 'true') {
            $query->whereHas('customerKavling');
        }
        // if sold is false, only show kavling that is not related to customer
        if ($this->sold == 'false') {
            $query->whereDoesntHave('customerKavling');
        }
        return $next($query);
    }

    /**
     * Get sold keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->sold) {
            return $this->sold;
        }

        $this->sold = request('sold', null);

        return request('sold');
    }
}
