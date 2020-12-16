<?php

declare(strict_types=1);

namespace Rawilk\Printing;

use Illuminate\Support\ServiceProvider;

class PrintingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/printing.php' => config_path('printing.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/printing.php', 'printing');

        $this->app->singleton(
            'printing.factory',
            function($app)
            {
                return new Factory($app['config']['printing']);
            }
        );

        $this->app->singleton('printing.driver',
            function($app) 
            {
            return $app['printing.factory']->driver(); 
            }
        );

        $this->app->singleton(
            Printing::class,
            function($app)
            {
                return new Printing($app['printing.driver'], $app['config']['printing.default_printer_id']);
            }
        );
    }

    public function provides()
    {
        return [
            'printing.factory',
            'printing.driver',
            Printing::class,
        ];
    }
}
