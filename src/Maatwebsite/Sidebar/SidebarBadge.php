<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Maatwebsite\Sidebar\Traits\Attributable;
use Maatwebsite\Sidebar\Traits\Authorizable;
use Maatwebsite\Sidebar\Traits\Itemable;
use Maatwebsite\Sidebar\Traits\Renderable;

class SidebarBadge
{
    /**
     * Traits
     */
    use Attributable, Renderable, Itemable, Authorizable;

    /**
     * @var
     */
    protected $factory;

    /**
     * Default view
     * @var string
     */
    protected $view = 'sidebar::badge';

    /**
     * @var string
     */
    protected $renderType = 'badge';

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     * @param Factory   $factory
     */
    public function __construct(Container $container, Factory $factory)
    {
        $this->container = $container;
        $this->factory = $factory;
    }

    /**
     * Init item
     * @return $this
     * @internal param $name
     */
    public function init()
    {
        return $this->cleanInstance();
    }
}
