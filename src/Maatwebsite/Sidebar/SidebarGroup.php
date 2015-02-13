<?php namespace Maatwebsite\Sidebar;

use Illuminate\Contracts\View\Factory;
use Maatwebsite\Sidebar\Traits\Itemable;
use Maatwebsite\Sidebar\Traits\Renderable;
use Maatwebsite\Sidebar\Traits\Attributable;
use Maatwebsite\Sidebar\Traits\Authorizable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\RouteDependencyResolverTrait;

class SidebarGroup {

    /**
     * Traits
     */
    use RouteDependencyResolverTrait, Attributable, Renderable, Itemable, Authorizable;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var SidebarItem
     */
    protected $item;

    /**
     * Default view
     * @var string
     */
    protected $view = 'sidebar::group';

    /**
     * @var string
     */
    protected $renderType = 'group';

    /**
     * @param Container           $container
     * @param Factory             $factory
     * @param         SidebarItem $item
     */
    public function __construct(Container $container, Factory $factory, SidebarItem $item)
    {
        $this->container = $container;
        $this->factory = $factory;
        $this->item = $item;
    }

    /**
     * @param                $name
     * @return SidebarGroup
     */
    public function init($name)
    {
        // Reset the object
        $instance = $this->cleanInstance();
        $instance->setAttribute('name', $name);

        return $instance;
    }

    /**
     * Get item instance
     * @return $this
     */
    public function getItem()
    {
        return $this->item;
    }
}
