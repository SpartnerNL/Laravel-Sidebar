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
        $this->app->singleton(
            'Maatwebsite\Sidebar\SidebarManager'
        );
    }
}
