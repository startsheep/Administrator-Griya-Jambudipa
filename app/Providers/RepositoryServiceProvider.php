<?php

namespace App\Providers;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Contracts\BaseRepositoryContract;
use App\Http\Repositories\Contracts\EmployeeContract;
use App\Http\Repositories\Contracts\PositionContract;
use App\Http\Repositories\Contracts\UserContract;
use App\Http\Repositories\EmployeeRepository;
use App\Http\Repositories\PositionRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(BaseRepositoryContract::class, BaseRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);
        $this->app->bind(PositionContract::class, PositionRepository::class);
        $this->app->bind(EmployeeContract::class, EmployeeRepository::class);
    }
}
