<?php namespace Maatwebsite\Sidebar;

use Closure;
use ReflectionFunction;
use Illuminate\Support\Facades\URL;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\View\Factory;
use Maatwebsite\Sidebar\Traits\Itemable;
use Maatwebsite\Sidebar\Traits\Routeable;
use Maatwebsite\Sidebar\Traits\Renderable;
use Maatwebsite\Sidebar\Traits\Attributable;
use Maatwebsite\Sidebar\Traits\Authorizable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\RouteDependencyResolverTrait;

class SidebarItem {

    /**
     * Traits
     */
    use RouteDependencyResolverTrait, Attributable, Renderable, Itemable, Routeable, Authorizable;

    /**
     * @var
     */
    protected $factory;

    /**
     * @var Translator
     */
    protected $translator;

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
     * @param Container     $container
     * @param Factory       $factory
     * @param Translator    $translator
     * @param SidebarBadge  $badgeGenerator
     * @param SidebarAppend $appendGenerator
     */
    public function __construct(Container $container, Factory $factory, Translator $translator, SidebarBadge $badgeGenerator, SidebarAppend $appendGenerator)
    {
        $this->container = $container;
        $this->factory = $factory;
        $this->translator = $translator;
        $this->badgeGenerator = $badgeGenerator;
        $this->appendGenerator = $appendGenerator;
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

        return $instance;
    }

    /**
     * Badge
     * @param Closure $callback
     * @param bool    $color
     * @return $this
     */
    public function badge($callback = null, $color = false)
    {
        $badge = $this->badgeGenerator->init();

        if ( $callback instanceof Closure )
        {
            $parameters = $this->resolveMethodDependencies(
                ['badge' => $badge], new ReflectionFunction($callback)
            );

            call_user_func_array($callback, $parameters);
        }
        elseif ( is_string($callback) )
        {
            $badge->setAttribute('value', $callback);

            if ( $color )
                $badge->setAttribute('color', $color);
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
     * @param callable $callback
     * @return $this
     */
    public function append($callback = null)
    {
        $append = $this->appendGenerator->init();

        if ( $callback instanceof Closure )
        {
            $parameters = $this->resolveMethodDependencies(
                ['append' => $append], new ReflectionFunction($callback)
            );
            call_user_func_array($callback, $parameters);
        }
        elseif ( is_string($callback) )
        {
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
        $langKey = 'menu.' . $value;

        if ( $this->translator->has($langKey) )
        {
            return $this->translator->get($langKey);
        }
        else
        {
            return ucfirst($value);
        }
    }


    /**
     * Get the state
     * @param $value
     * @return string
     */
    public function getState($value = '')
    {
        if ( !$value && $this->checkActiveState() )
            return 'active';

        return $value;
    }

    /**
     * Check the active state
     * @return mixed
     */
    protected function checkActiveState()
    {
        // Check if one of the children is active
        foreach ($this->items as $item)
        {
            if ( $item->checkActiveState() )
                return true;
        }

        // $this->route is already transformed to an url
        return $this->route == URL::current() ? true : false;
    }
}
