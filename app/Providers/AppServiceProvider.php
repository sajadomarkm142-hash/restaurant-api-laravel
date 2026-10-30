<?php

namespace App\Providers;

use App\Repositories\BranchRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\InventoryRepository;
use App\Repositories\OrderRepository;
use App\Services\BranchService;
use App\Services\CustomerService;
use App\Services\InventoryService;
use App\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BranchRepository::class, fn () => new BranchRepository());
        $this->app->singleton(CustomerRepository::class, fn () => new CustomerRepository());
        $this->app->singleton(InventoryRepository::class, fn () => new InventoryRepository());
        $this->app->singleton(OrderRepository::class, fn () => new OrderRepository());

        $this->app->singleton(BranchService::class, fn ($app) => new BranchService($app->make(BranchRepository::class)));
        $this->app->singleton(CustomerService::class, fn ($app) => new CustomerService($app->make(CustomerRepository::class)));
        $this->app->singleton(InventoryService::class, fn ($app) => new InventoryService($app->make(InventoryRepository::class)));
        $this->app->singleton(OrderService::class, fn ($app) => new OrderService($app->make(OrderRepository::class)));
    }

    public function boot(): void
    {
        //
    }
}
