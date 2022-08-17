<?php

namespace App\Http\Services\Searches\Filters\Position;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;
use App\Models\Position;

class Sort implements FilterContract
{
    /** @var string|null */
    protected $defaultSortField = 'id';

    public function classes()
    {
        return [
            new Position(),
        ];
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        $sortField = request('order_by', request()->order_by ? request()->order_by : '');
        $sortOrder = request('order_direction', request()->order_direction ? request()->order_direction : '');

        $isSortAvailable = $this->isSortFieldAvailable($sortField);
        if ($isSortAvailable) {
            $query->orderBy($sortField, $sortOrder);
        }

        return $next($query);
    }

    protected function isSortFieldAvailable(string $sort): bool
    {
        $fillable = $this->getAllFillable();

        return in_array($sort, $fillable);
    }

    protected function getAllFillable(): array
    {
        $classes = $this->classes();

        $fillable = [];

        foreach ($classes as $class) {
            $keys = $class->getTable();

            foreach ($class->getFillable() as $fill) {
                $fillable[] = $keys . '.' . $fill;
            }
        }

        return $fillable;
    }
}
