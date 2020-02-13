<?php

namespace JorarMarfin\LaravelDspace;

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use JorarMarfin\LaravelDspace\Controllers\MainController;

class LaravelDspaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('LaravelDspace', function()
        {
            return new MainController;
        });
        App::booting( function()
        {
            $loader = AliasLoader::getInstance();
            $loader->alias('LaravelDspace', 'JorarMarfin\LaravelDspace\Facades\LaravelDspaceFacade');
        });
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
