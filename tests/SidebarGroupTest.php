<?php

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\View\Factory;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use Mockery as m;

class SidebarGroupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SidebarGroup
     */
    protected $group;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var SidebarItem
     */
    protected $item;

    public function setUp()
    {
        $this->container = m::mock(Container::class);

        $this->factory = m::mock(Factory::class);
        $this->item    = m::mock(SidebarItem::class);
        $this->item->shouldReceive('init')->andReturnSelf();

        $this->group = new SidebarGroup(
            $this->container,
            $this->factory,
            $this->item
        );
    }

    public function test_can_init()
    {
        $this->container->shouldReceive('make')->with(SidebarGroup::class)->andReturn(new SidebarGroup(
            $this->container,
            $this->factory,
            $this->item
        ));

        $group = $this->group->init('groupName');

        $this->assertEquals('groupName', $group->name);
        $this->assertEquals(1, $group->weight);
        $this->assertInstanceOf(Collection::class, $group->getItems());
    }

    public function test_can_hide_heading()
    {
        $this->group->hideHeading(true);
        $this->assertFalse($this->group->shouldShowHeading());

        $this->group->hideHeading(false);
        $this->assertTrue($this->group->shouldShowHeading());
    }
}
