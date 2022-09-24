<?php

namespace App\Http\Services\Searches\Filters\Log;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Services\Searches\Contracts\FilterContract;

class UserId implements FilterContract
{
    /** @var string|null */
    protected $userId;

    /**
     * @param string|null $userId
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $query->when($id = $this->userId, function ($query) use ($id) {
            $query->whereHas('user', function ($queryUser) use ($id) {
                $queryUser->where('id', $id);
            });
        });

        return $next($query);
    }

    /**
     * Get userId keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->userId) {
            return $this->userId;
        }

        $this->userId = request('user_id', null);

        return request('user_id');
    }
}
