<?php
namespace App\Http\Services\Searches\Filters\HouseType;

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
		// query in rlationship table search  house_type in kavling table
        $query->whereHas('kavling', function ($query) {
            $query->where('house_type', 'like', '%' . $this->name . '%');
        });

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
