<?php

namespace App\Providers;

use App\Interfaces\IArticleRepository;
use App\Interfaces\IArticleService;
use App\Repository\ArticleRepository;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->registerRepositoryInterface();
        $this->registerServiceInterface();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }


    /**
     * Interface mapping to Repositories
     *
     * @var array
     */
    private static $repositoryInterfaces = [
        IArticleRepository::class => ArticleRepository::class,

    ];
    /**
     * Interface mapping to Services
     *
     * @var array
     */
    private static $servicesInterfaces = [
        IArticleService::class => ArticleService::class,

    ];

    /**
     *Biding Repository interfaces to the definitions
     */
    private function registerRepositoryInterface()
    {
        foreach (self::$repositoryInterfaces as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     *
     * Binding Services interfaces to the definitions
     */
    private function registerServiceInterface()
    {
        foreach (self::$servicesInterfaces as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
