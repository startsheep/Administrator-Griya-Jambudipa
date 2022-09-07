<?php

namespace App\Http\Services\Searches\Filters\BasicPriceCategory;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class Section implements FilterContract
{
    /** @var string|null */
    protected $section;

    /**
     * @param string|null $section
     * @return void
     */
    public function __construct($section)
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        $query->where('section', 'LIKE', '%' . $this->section . '%');

        return $next($query);
    }

    /**
     * Get section keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->section) {
            return $this->section;
        }

        $this->section = request('section', null);

        return request('section');
    }
}
