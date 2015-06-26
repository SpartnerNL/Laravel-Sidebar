<?php

namespace Maatwebsite\Sidebar\Domain\Events;

use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\SidebarManager;

class FlushesSidebarCache
{
    /**
     * @var SidebarManager
     */
    protected $manager;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container      $container
     * @param SidebarManager $manager
     */
    public function __construct(Container $container, SidebarManager $manager)
    {
        $this->manager   = $manager;
        $this->container = $container;
    }

    /**
     * Flush the sidebar cache
     */
    public function handle()
    {
        $this->container->call([
            $this->manager,
            'flush'
        ]);
    }
}
