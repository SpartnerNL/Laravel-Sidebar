<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\Exceptions\LogicException;
use Maatwebsite\Sidebar\Infrastructure\SidebarResolver;

class SidebarManager
{
    /**
     * @var array
     */
    protected $sidebars = [];

    /**
     * @var
     */
    protected $container;

    /**
     * @var SidebarResolver
     */
    protected $resolver;

    /**
     * @param Container       $container
     * @param SidebarResolver $resolver
     */
    public function __construct(Container $container, SidebarResolver $resolver)
    {
        $this->container = $container;
        $this->resolver  = $resolver;
    }

    /**
     * Register the sidebar
     *
     * @param $name
     *
     * @return $this
     * @throws LogicException
     */
    public function register($name)
    {
        if (class_exists($name)) {
            $this->sidebars[$name] = null;
        } else {
            throw new LogicException('Sidebar [' . $name . '] does not exist');
        }

        return $this;
    }

    /**
     * Bind sidebar instances to the ioC
     */
    public function resolve()
    {
        foreach ($this->sidebars as $name => $instance) {

            // Don't resolve twice
            if (!$instance) {
                $sidebar = $this->resolver->resolve($name);

                $this->sidebars[$name] = $this->container->singleton($name, function () use ($sidebar) {
                    return $sidebar;
                });
            }
        }
    }
}
