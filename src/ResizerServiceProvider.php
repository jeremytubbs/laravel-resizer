<?php

namespace Jeremytubbs\LaravelResizer;

use Blade;
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
        Blade::directive('picturefill', function() {
        return <<<EOF
<script>
    // Picture element HTML5 shiv
    document.createElement( "picture" );
</script>
<script src="/vendor/laravel-resizer/picturefill.min.js" async></script>
EOF;
        });

        Blade::directive('srcset', function($asset) {
            $asset = trim($asset, "('..')");
            $asset_parts = pathinfo($asset);
            $asset_2x = $asset_parts['dirname'].'/'.$asset_parts['filename'].'@2x.'.$asset_parts['extension'];
            return <<<EOF
<img srcset="$asset 1x, $asset_2x 2x">
EOF;
        });
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

        $this->publishes([
            __DIR__.'/assets/vendor/' => public_path('vendor/laravel-resizer'),
        ], 'public');

        $this->commands([
            'Jeremytubbs\LaravelResizer\Console\Commands\ResizeImageCommand',
        ]);
    }
}
