<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\Infrastructure\BuilderCacheDecoratorFactory;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $shortName = 'sidebar';

    /**
     * Boot the service provider.
     * @return void
     */
    public function boot()
    {
        $this->registerViews();
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->app->singleton('Maatwebsite\Sidebar\Builder', function ($app) {

            $builder = $app->make('Maatwebsite\Sidebar\Domain\DefaultBuilder');

            if ($cache = $app['config'][$this->shortName]['cache']['method']) {
                return $app->make(
                    BuilderCacheDecoratorFactory::getClassName($cache),
                    [$builder]
                );
            }

            return $builder;
        });

        $this->app->bind(
            'Maatwebsite\Sidebar\Menu',
            'Maatwebsite\Sidebar\Domain\DefaultMenu'
        );

        $this->app->bind(
            'Maatwebsite\Sidebar\Group',
            'Maatwebsite\Sidebar\Domain\DefaultGroup'
        );

        $this->app->bind(
            'Maatwebsite\Sidebar\Presentation\SidebarRenderer',
            'Maatwebsite\Sidebar\Presentation\Illuminate\IlluminateSidebarRenderer'
        );
    }

    /**
     * Register views.
     * @return void
     */
    protected function registerViews()
    {
        $location = __DIR__ . '/../resources/views';

        $this->loadViewsFrom($location, $this->shortName);

        $this->publishes([
            $location => base_path('resources/views/vendor/' . $this->shortName),
        ], 'views');
    }

    /**
     * Register config
     * @return void
     */
    protected function registerConfig()
    {
        $location = __DIR__ . '/../config/' . $this->shortName . '.php';

        $this->mergeConfigFrom(
            $location, $this->shortName
        );

        $this->publishes([
            $location => config_path($this->shortName . '.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
            'Maatwebsite\Sidebar\Builder',
            'Maatwebsite\Sidebar\Menu'
        ];
    }
}
