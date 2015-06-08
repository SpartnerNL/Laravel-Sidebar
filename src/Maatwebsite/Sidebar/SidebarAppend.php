<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Maatwebsite\Sidebar\Traits\Attributable;
use Maatwebsite\Sidebar\Traits\Authorizable;
use Maatwebsite\Sidebar\Traits\Itemable;
use Maatwebsite\Sidebar\Traits\Renderable;
use Maatwebsite\Sidebar\Traits\Routeable;

class SidebarAppend
{
    /**
     * Traits
     */
    use Attributable, Renderable, Itemable, Routeable, Authorizable;

    /**
     * @var
     */
    protected $factory;

    /**
     * Default view
     * @var string
     */
    protected $view = 'sidebar::append';

    /**
     * @var string
     */
    protected $renderType = 'append';

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
        $this->factory   = $factory;
        $this->container = $container;
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
