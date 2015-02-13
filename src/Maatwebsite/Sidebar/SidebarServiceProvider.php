<?php namespace Maatwebsite\Sidebar;

use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $views = __DIR__ . '/../../resources/views';

        $this->loadViewsFrom($views, 'sidebar');

        $this->publishes([
            $views => base_path('resources/views/vendor/sidebar'),
        ]);

        $this->app->singleton(
            'Maatwebsite\Sidebar\SidebarManager'
        );
    }
}
