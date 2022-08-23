<?php

namespace App\Providers;

use App\Http\Repositories\AccountRepository;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\CompanyProfileRepository;
use App\Http\Repositories\Contracts\AccountContract;
use App\Http\Repositories\Contracts\BaseRepositoryContract;
use App\Http\Repositories\Contracts\CompanyProfileContract;
use App\Http\Repositories\Contracts\CustomerContract;
use App\Http\Repositories\Contracts\EmployeeContract;
use App\Http\Repositories\Contracts\HouseTypeContract;
use App\Http\Repositories\Contracts\KavlingContract;
use App\Http\Repositories\Contracts\PositionContract;
use App\Http\Repositories\Contracts\UserContract;
use App\Http\Repositories\CustomerRepository;
use App\Http\Repositories\EmployeeRepository;
use App\Http\Repositories\HouseTypeRepository;
use App\Http\Repositories\KavlingRepository;
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
        $this->app->bind(CompanyProfileContract::class, CompanyProfileRepository::class);
        $this->app->bind(CustomerContract::class, CustomerRepository::class);
        $this->app->bind(HouseTypeContract::class, HouseTypeRepository::class);
        $this->app->bind(KavlingContract::class, KavlingRepository::class);
        $this->app->bind(AccountContract::class, AccountRepository::class);
    }
}
