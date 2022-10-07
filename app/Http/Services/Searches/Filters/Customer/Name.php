<?php

namespace App\Http\Services\Searches\Filters\Customer;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Name implements FilterContract
{
    /** @var string|null */
    protected $name;

    /**
     * @param string|null $name
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $name = $this->name;

        $query->where('name', 'LIKE', '%' . $name . '%')
            ->orWhere('phone', 'LIKE', '%' . $name . '%')
            ->orWhere('email', 'LIKE', '%' . $name . '%');

        return $next($query);
    }

    /**
     * Get name keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->name) {
            return $this->name;
        }

        $this->name = request('name', null);

        return request('name');
    }
}
