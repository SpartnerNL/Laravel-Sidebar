<?php

namespace Maatwebsite\Sidebar\Domain;

use Closure;
use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\Builder;
use Maatwebsite\Sidebar\Exceptions\LogicException;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Traits\CallableTrait;
use Serializable;

class DefaultBuilder implements Builder, Serializable
{
    use CallableTrait;

    /**
     * @var Menu|null
     */
    protected $menu;

    /**
     * @var Container
     */
    protected $container;

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
        $this->menu = $this->menu ?: $this->container->make(Menu::class);

        $this->call($callback, $this->getMenu());

        return $this;
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
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize([
            'menu' => $this->menu
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized The string representation of the object.
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->menu = $data['menu'];
    }
}
