<?php

namespace App\Http\Services\Searches\Filters\Payment;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;
use Illuminate\Support\Facades\DB;

class PriceHouse implements FilterContract
{
    /** @var string|null */
    protected $priceHouse;

    /**
     * @param string|null $priceHouse
     * @return void
     */
    public function __construct($priceHouse)
    {
        $this->priceHouse = $priceHouse;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        // DB::table('users')
    }

    /**
     * Get priceHouse keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->priceHouse) {
            return $this->priceHouse;
        }

        $this->priceHouse = request('price_house', null);

        return request('price_house');
    }
}
