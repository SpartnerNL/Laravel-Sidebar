<?php

namespace Maatwebsite\Sidebar;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\RouteDependencyResolverTrait;
use Illuminate\Support\Collection;
use ReflectionFunction;

class SidebarManager
{
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
    protected $withoutGroupHeading = false;

    /**
     * @var Collection
     */
    public $groups;

    /**
     * @param Container    $container
     * @param SidebarGroup $group
     */
    public function __construct(Container $container, SidebarGroup $group)
    {
        $this->container = $container;
        $this->group     = $group;
        $this->groups    = new Collection;
    }

    /**
     * Build the sidebar menu
     * @param $callback
     * @return $this
     */
    public function build($callback = null)
    {
        if ($callback instanceof Closure) {
            call_user_func($callback, $this);
        }

        return $this;
    }

    /**
     * Disable groups
     * @return $this
     */
    public function withoutGroup()
    {
        $this->withoutGroupHeading = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithoutGroupHeading()
    {
        return $this->withoutGroupHeading;
    }

    /**
     * Start grouping our items
     * @param  string       $name
     * @param  Closure      $callback
     * @return SidebarGroup
     */
    public function group($name, $callback = null)
    {
        if (! $this->groupExists($name)) {
            $group = $this->group->init($name);
        } else {
            $group = $this->getGroup($name);
        }

        if ($callback instanceof Closure) {
            // Make dependency injection possible
            $parameters = $this->resolveMethodDependencies(
                ['group' => $group], new ReflectionFunction($callback)
            );

            call_user_func_array($callback, $parameters);
        }

        // Add the group to our menu groups
        if (! empty($group)) {
            $this->setGroup($name, $group);
        }

        // Return the group object
        return $group;
    }

    /**
     * Render the sidebar
     * @return string
     */
    public function render()
    {
        $html = '<ul class="sidebar-menu">';

        // Order by weight
        $groups = $this->groups->sortBy('weight');

        foreach ($groups as $group) {
            // Don't overrule user preferences
            if (! isset($group->hideHeading)) {
                $group->hideHeading($this->withoutGroupHeading);
            }

            $html .= $group->render();
        }

        return $html . '</ul>';
    }

    /**
     * @param $name
     * @return bool
     */
    public function groupExists($name)
    {
        return $this->groups->has($this->getNameKey($name));
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getGroup($name)
    {
        return $this->groups->get($this->getNameKey($name));
    }

    /**
     * @param $name
     * @param $group
     */
    public function setGroup($name, $group)
    {
        $this->groups->put($this->getNameKey($name), $group);
    }

    /**
     * When echo'd, render the object to a string
     * @return string [description]
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param $name
     * @return string
     */
    protected function getNameKey($name)
    {
        return md5($name);
    }

    /**
     * @return Collection|SidebarGroup[]
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
