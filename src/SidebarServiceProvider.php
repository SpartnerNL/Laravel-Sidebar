<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\Infrastructure\SidebarFlusherFactory;
use Maatwebsite\Sidebar\Infrastructure\SidebarResolverFactory;

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
        // Register config
        $this->registerConfig();

        // Bind SidebarResolver
        $this->app->bind('Maatwebsite\Sidebar\Infrastructure\SidebarResolver', function (Application $app) {

            $resolver = SidebarResolverFactory::getClassName(
                $app['config']->get('sidebar.cache.method')
            );

            return $app->make($resolver);
        });

        // Bind SidebarFlusher
        $this->app->bind('Maatwebsite\Sidebar\Infrastructure\SidebarFlusher', function (Application $app) {

            $resolver = SidebarFlusherFactory::getClassName(
                $app['config']->get('sidebar.cache.method')
            );

            return $app->make($resolver);
        });

        // Bind manager
        $this->app->singleton('Maatwebsite\Sidebar\SidebarManager');

        // Bind Menu
        $this->app->bind(
            'Maatwebsite\Sidebar\Menu',
            'Maatwebsite\Sidebar\Domain\DefaultMenu'
        );

        // Bind Group
        $this->app->bind(
            'Maatwebsite\Sidebar\Group',
            'Maatwebsite\Sidebar\Domain\DefaultGroup'
        );

        // Bind Item
        $this->app->bind(
            'Maatwebsite\Sidebar\Item',
            'Maatwebsite\Sidebar\Domain\DefaultItem'
        );

        // Bind Badge
        $this->app->bind(
            'Maatwebsite\Sidebar\Badge',
            'Maatwebsite\Sidebar\Domain\DefaultBadge'
        );

        // Bind Append
        $this->app->bind(
            'Maatwebsite\Sidebar\Append',
            'Maatwebsite\Sidebar\Domain\DefaultAppend'
        );

        // Bind Renderer
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
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
            'Maatwebsite\Sidebar\Menu',
            'Maatwebsite\Sidebar\Item',
            'Maatwebsite\Sidebar\Group',
            'Maatwebsite\Sidebar\Badge',
            'Maatwebsite\Sidebar\Append',
            'Maatwebsite\Sidebar\SidebarManager',
            'Maatwebsite\Sidebar\Presentation\SidebarRenderer',
            'Maatwebsite\Sidebar\Infrastructure\SidebarResolver'
        ];
    }
}
