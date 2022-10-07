<?php

namespace App\Http\Services\Searches\Filters\Transaction;

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

        $search = $this->search;

        $query->whereHas('customer', function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%');
            $q->orWhere('phone', 'LIKE', '%' . $search . '%');
        })->orWhereHas('kavling', function ($q) use ($search) {
            $q->where('block', $search);
            $q->orWhere('number_kavling', $search);
            $q->orWhereHas('houseType', function ($q2) use ($search) {
                $q2->where('house_type', 'LIKE', '%' . $search . '%');
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
