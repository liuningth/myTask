<?php

namespace App\Providers;

use App\Repositories\UserRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryEloquent;
use App\Repositories\CouponRepository;
use App\Repositories\CouponRepositoryEloquent;
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
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryEloquent::class);
        $this->app->bind(CouponRepository::class, CouponRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
