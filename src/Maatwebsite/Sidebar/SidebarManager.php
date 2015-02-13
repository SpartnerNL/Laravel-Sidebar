<?php namespace Maatwebsite\Sidebar;

use Closure;
use ReflectionFunction;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\RouteDependencyResolverTrait;

class SidebarManager {

    /**
     * Traits
     */
    use RouteDependencyResolverTrait;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var SidebarGroup
     */
    protected $group;

    /**
     * @var bool
     */
    protected $groupsEnabled = true;

    /**
     * @var array
     */
    public $groups = [];

    /**
     * @param Container    $container
     * @param SidebarGroup $group
     */
    public function __construct(Container $container, SidebarGroup $group)
    {
        $this->container = $container;
        $this->group = $group;
    }

    /**
     * Build the sidebar menu
     * @param $callback
     * @return $this
     */
    public function build($callback = null)
    {
        if ( $callback instanceof Closure )
            call_user_func($callback, $this);

        return $this;
    }

    /**
     * Disable groups
     */
    public function groupLess()
    {
        $this->groupsEnabled = false;

        return $this;
    }

    /**
     * Start grouping our items
     * @param  string  $name
     * @param  Closure $callback
     * @return SidebarGroup
     */
    public function group($name, $callback = null)
    {
        // Create a new group
        $group = $this->group->init($name);

        if ( $callback instanceof Closure )
        {
            // Make dependency injection possible
            $parameters = $this->resolveMethodDependencies(
                ['group' => $group], new ReflectionFunction($callback)
            );

            call_user_func_array($callback, $parameters);
        }

        // Add the group to our menu groups
        if ( !empty($group) )
            $this->groups[] = $group;

        // Return the group object
        return $group;
    }

    /**
     * Render the sidebar
     * @return string
     */
    public function render()
    {
        $html = '';
        foreach ($this->groups as $group)
        {
            $group->setAttribute('enabled', $this->groupsEnabled);

            $html .= $group->render();
        }

        return $html;
    }

    /**
     * When echo'd, render the object to a string
     * @return string [description]
     */
    public function __toString()
    {
        return $this->render();
    }
}
