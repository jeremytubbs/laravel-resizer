<?php

namespace Jeremytubbs\LaravelResizer;

use Illuminate\Support\ServiceProvider;

class ResizerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

        /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/../config/resizer.php' => config_path('resizer.php'),
        ], 'config');

        $this->commands([
            'Jeremytubbs\LaravelResizer\Console\Commands\ResizeImageCommand',
        ]);
    }
}
