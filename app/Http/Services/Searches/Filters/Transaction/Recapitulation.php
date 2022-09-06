<?php

namespace App\Http\Services\Searches\Filters\Transaction;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Recapitulation implements FilterContract
{
    /** @var string|null */
    protected $recapitulation;

    /**
     * @param string|null $recapitulation
     * @return void
     */
    public function __construct($recapitulation)
    {
        $this->recapitulation = $recapitulation;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        // dd(request()->segment(2));
        if(request()->segment(2)=='transaction'){
            if(request('from') && request('to')){
                $query->whereBetween('created_at', [request('from'), request('to')]);
            }
            // $query->whereBetween('created_at', [request('from'), request('to')]);
        }

        return $next($query);
    }

    /**
     * Get recapitulation keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->recapitulation) {
            return $this->recapitulation;
        }

        $this->recapitulation = request('recapitulation', null);

        return request('recapitulation');
    }
}
