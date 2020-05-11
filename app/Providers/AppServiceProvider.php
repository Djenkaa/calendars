<?php

namespace App\Providers;

use App\Repositories\CalendarRepository;
use App\Repositories\Interfaces\CalendarRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    public $singletons = [
       CalendarRepositoryInterface::class=>CalendarRepository::class
    ];



    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength('191');
    }
}
