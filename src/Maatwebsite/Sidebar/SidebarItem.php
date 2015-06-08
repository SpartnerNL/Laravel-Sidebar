<?php

namespace Maatwebsite\Sidebar;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteDependencyResolverTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Sidebar\Traits\Attributable;
use Maatwebsite\Sidebar\Traits\Authorizable;
use Maatwebsite\Sidebar\Traits\Itemable;
use Maatwebsite\Sidebar\Traits\Renderable;
use Maatwebsite\Sidebar\Traits\Routeable;
use ReflectionFunction;

class SidebarItem
{
    /**
     * Traits
     */
    use RouteDependencyResolverTrait, Attributable, Renderable, Itemable, Routeable, Authorizable;

    /**
     * @var
     */
    protected $factory;

    /**
     * Default view
     * @var string
     */
    protected $view = 'sidebar::item';

    /**
     * @var string
     */
    protected $renderType = 'item';

    /**
     * @var SidebarBadge
     */
    private $badgeGenerator;

    /**
     * @var array
     */
    public $badges = [];

    /**
     * @var array
     */
    public $appends = [];

    /**
     * @var Container
     */
    private $container;

    /**
     * @var SidebarAppend
     */
    private $appendGenerator;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Container     $container
     * @param Request       $request
     * @param Factory       $factory
     * @param SidebarBadge  $badgeGenerator
     * @param SidebarAppend $appendGenerator
     */
    public function __construct(Container $container, Request $request, Factory $factory, SidebarBadge $badgeGenerator, SidebarAppend $appendGenerator)
    {
        $this->container       = $container;
        $this->factory         = $factory;
        $this->badgeGenerator  = $badgeGenerator;
        $this->appendGenerator = $appendGenerator;
        $this->request         = $request;
    }

    /**
     * Init item
     * @param $name
     * @return $this
     */
    public function init($name)
    {
        $instance = $this->cleanInstance();
        $instance->setAttribute('name', $name);
        $instance->setAttribute('weight', 1);
        $instance->items = new Collection;

        return $instance;
    }

    /**
     * Set active state
     * @param  bool  $condition
     * @return $this
     */
    public function isActiveWhen($condition = true)
    {
        $this->active = $condition;

        return $this;
    }

    /**
     * Badge
     * @param  Closure $callback
     * @param  bool    $color
     * @return $this
     */
    public function badge($callback = null, $color = false)
    {
        $badge = $this->badgeGenerator->init();

        if ($callback instanceof Closure) {
            $parameters = $this->resolveMethodDependencies(
                ['badge' => $badge], new ReflectionFunction($callback)
            );
            call_user_func_array($callback, $parameters);
        } elseif (is_string($callback)) {
            $badge->setAttribute('value', $callback);
            if ($color) {
                $badge->setAttribute('color', $color);
            }
        }

        $this->badges[] = $badge;

        return $badge;
    }

    /**
     * Has a badge
     * @return bool
     */
    public function hasBadge()
    {
        return count($this->badges) > 0;
    }

    /**
     * Append something
     * @param  callable $callback
     * @return $this
     */
    public function append($callback = null)
    {
        $append = $this->appendGenerator->init();

        if ($callback instanceof Closure) {
            $parameters = $this->resolveMethodDependencies(
                ['append' => $append], new ReflectionFunction($callback)
            );
            call_user_func_array($callback, $parameters);
        } elseif (is_string($callback)) {
            // just a route
            $append->route($callback);
        }

        $this->appends[] = $append;

        return $append;
    }

    /**
     * Check if has append
     * @return bool
     */
    public function hasAppend()
    {
        return count($this->appends) > 0;
    }

    /**
     * Get item instance
     * @return $this
     */
    public function getItem()
    {
        return $this;
    }

    /**
     * Get the name
     * @param $value
     * @return string
     */
    public function getName($value)
    {
        return $value;
    }

    /**
     * Get the state
     * @param $value
     * @return string
     */
    public function getState($value = '')
    {
        if (! $value && $this->checkActiveState()) {
            return 'active';
        }

        return $value;
    }

    /**
     * Check the active state
     * @return bool
     */
    protected function checkActiveState()
    {
        // Check if one of the children is active
        foreach ($this->items as $item) {
            if ($item->checkActiveState()) {
                return true;
            }
        }

        // If the active state was manually set
        if (! is_null($this->active)) {
            return $this->active;
        }

        $path = ltrim(str_replace(url('/'), '', $this->route), '/');

        return $this->request->is(
            $path,
            $path . '/*'
        );
    }
}
