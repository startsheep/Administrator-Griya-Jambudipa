<?php

namespace App\Http\Services\Searches\Filters\Kavling;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class IsReady implements FilterContract
{
    /** @var string|null */
    protected $isReady;

    /**
     * @param string|null $isReady
     * @return void
     */
    public function __construct($isReady)
    {
        $this->isReady = $isReady;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
    //    only show kavling that is not related to house_type
    if($this->isReady == 'true'){}
        $query->doesntHave('houseType');
        return $next($query);
    }

    /**
     * Get isReady keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->isReady) {
            return $this->isReady;
        }

        $this->isReady = request('isReady', null);

        return request('isReady');
    }
}
