<?php

namespace Maatwebsite\Sidebar\Tests;

use Maatwebsite\Sidebar\Domain\DefaultGroup;
use Maatwebsite\Sidebar\Domain\DefaultMenu;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender;
use Mockery as m;
use PHPUnit\Framework\TestCase as TestCase;

class SidebarExtenderTest extends TestCase
{
    /**
     * @var Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var DefaultMenu
     */
    protected $menu;

    protected function setUp(): void
    {
        $this->container = m::mock('Illuminate\Contracts\Container\Container');
        $this->menu      = new DefaultMenu($this->container);
    }

    public function test_a_sidebar_can_be_extended_with_an_extender()
    {
        $group = new DefaultGroup($this->container);
        $group->name('original');
        $this->menu->addGroup($group);

        $extender = new StubSidebarExtender();
        $extender->extendWith($this->menu);

        $this->menu->add(
            $extender->extendWith($this->menu)
        );

        $this->assertInstanceOf('Maatwebsite\Sidebar\Menu', $this->menu);
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->menu->getGroups());
        $this->assertCount(2, $this->menu->getGroups());
    }
}

class StubSidebarExtender implements SidebarExtender
{
    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $container = m::mock('Illuminate\Contracts\Container\Container');

        $group = new DefaultGroup($container);
        $group->name('new from extender');
        $menu->addGroup($group);

        $group = new DefaultGroup($container);
        $group->name('original');
        $menu->addGroup($group);

        return $menu;
    }
}
