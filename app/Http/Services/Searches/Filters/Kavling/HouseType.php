<?php

namespace App\Http\Services\Searches\Filters\Kavling;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class HouseType implements FilterContract
{
    /** @var string|null */
    protected $houseType;

    /**
     * @param string|null $houseType
     * @return void
     */
    public function __construct($houseType)
    {
        $this->houseType = $houseType;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $query->when($houseType = $this->houseType, function ($q) use ($houseType) {
            $q->whereHas('houseType', function ($houseTypeQuery) use ($houseType) {
                $houseTypeQuery->where('house_type', 'LIKE', '%' . $houseType . '%');
            });
        });

        return $next($query);
    }

    /**
     * Get houseType keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->houseType) {
            return $this->houseType;
        }

        $this->houseType = request('house_type', null);

        return request('house_type');
    }
}
