<?php

namespace Maatwebsite\Sidebar\Domain;

use Closure;
use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\Builder;
use Maatwebsite\Sidebar\Exceptions\LogicException;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Maatwebsite\Sidebar\Traits\CallableTrait;
use Serializable;

class DefaultBuilder implements Builder, Serializable
{
    use CallableTrait, CacheableTrait;

    /**
     * @var Menu|null
     */
    protected $menu;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Data that should be cached
     * @var array
     */
    protected $cacheables = [
        'menu'
    ];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param callable $callback
     *
     * @return Builder
     */
    public function build(Closure $callback = null)
    {
        $this->menu = $this->menu ?: $this->container->make('Maatwebsite\Sidebar\Menu');

        $this->call($callback, $this->getMenu());

        return $this->menu;
    }

    /**
     * @return Menu|null
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param Menu $menu
     *
     * @return Builder
     */
    public function setMenu(Menu $menu)
    {
        if ($this->menu) {
            throw new LogicException('You can only set a menu on an empty builder');
        }

        $this->menu = $menu;

        return $this;
    }

    /**
     * Render Sidebar to HTML
     * @return string
     */
    public function render()
    {
        if (!$this->menu) {
            throw new LogicException('You first have to build the menu');
        }

        return $this->menu->render();
    }
}
