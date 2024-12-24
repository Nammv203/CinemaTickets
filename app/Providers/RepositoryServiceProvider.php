<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function boot()
    {
        // $this->app->bind(\Modules\Core\Repositories\PlanRepository::class, \Modules\Core\Repositories\PlanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FilmRepository::class, \App\Repositories\FilmRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CategoryRepository::class, \App\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CinemaRepository::class, \App\Repositories\CinemaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TicketRepository::class, \App\Repositories\TicketRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CinemaRoomRepository::class, \App\Repositories\CinemaRoomRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CinemaRoomChairRepository::class, \App\Repositories\CinemaRoomChairRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderRepository::class, \App\Repositories\OrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderItemRepository::class, \App\Repositories\OrderItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LocationProvinceRepository::class, \App\Repositories\LocationProvinceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LocationDistrictRepository::class, \App\Repositories\LocationDistrictRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\SchedulePublishFilmRepository::class, \App\Repositories\SchedulePublishFilmRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TicketOrderRepository::class, \App\Repositories\TicketOrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TicketOrderItemRepository::class, \App\Repositories\TicketOrderItemRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
