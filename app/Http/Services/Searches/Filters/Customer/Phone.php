<?php

namespace App\Http\Services\Searches\Filters\Customer;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Phone implements FilterContract
{
    /** @var string|null */
    protected $phone;

    /**
     * @param string|null $phone
     * @return void
     */
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        $query->where('phone', 'LIKE', '%' . $this->phone . '%');

        return $next($query);
    }

    /**
     * Get phone keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->phone) {
            return $this->phone;
        }

        $this->phone = request('phone', null);

        return request('phone');
    }
}
