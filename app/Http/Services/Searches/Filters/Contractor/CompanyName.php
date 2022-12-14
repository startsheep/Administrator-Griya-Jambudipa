<?php

namespace App\Http\Services\Searches\Filters\Contractor;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class CompanyName implements FilterContract
{
    /** @var string|null */
    protected $companyName;

    /**
     * @param string|null $companyName
     * @return void
     */
    public function __construct($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        $query->where('pic_name', 'LIKE', '%' . $this->companyName . '%');
        $query->orWhere('email', 'LIKE', '%' . $this->companyName . '%');
        $query->orWhere('phone', 'LIKE', '%' . $this->companyName . '%');

        return $next($query);
    }

    /**
     * Get companyName keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->companyName) {
            return $this->companyName;
        }

        $this->companyName = request('name', null);

        return request('name');
    }
}
