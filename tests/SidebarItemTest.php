<?php

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\Factory;
use Maatwebsite\Sidebar\SidebarAppend;
use Maatwebsite\Sidebar\SidebarBadge;
use Maatwebsite\Sidebar\SidebarItem;
use Mockery as m;

class SidebarItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SidebarItem
     */
    protected $item;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var SidebarBadge
     */
    protected $badge;

    /**
     * @var SidebarAppend
     */
    protected $append;

    /**
     * @var Request
     */
    protected $request;

    public function setUp()
    {
        $this->container = m::mock(Container::class);
        $this->request   = m::mock(Request::class);
        $this->factory   = m::mock(Factory::class);
        $this->badge     = m::mock(SidebarBadge::class);
        $this->badge->shouldReceive('init')->andReturnSelf();
        $this->append = m::mock(SidebarAppend::class);
        $this->append->shouldReceive('init')->andReturnSelf();

        $this->item = new SidebarItem(
            $this->container,
            $this->request,
            $this->factory,
            $this->badge,
            $this->append
        );
    }

    public function test_can_init()
    {
        $this->container->shouldReceive('make')->with(SidebarItem::class)->andReturn(new SidebarItem(
            $this->container,
            $this->request,
            $this->factory,
            $this->badge,
            $this->append
        ));

        $item = $this->item->init('itemName');

        $this->assertEquals('itemName', $item->name);
        $this->assertEquals(1, $item->weight);
        $this->assertInstanceOf(Collection::class, $item->getItems());
    }

    public function test_can_manually_set_active_state()
    {
        $this->assertNull($this->item->active);
        $this->item->isActiveWhen(true);
        $this->assertTrue($this->item->active);
        $this->item->isActiveWhen(false);
        $this->assertFalse($this->item->active);
    }

    public function test_can_get_active_state()
    {
        $this->request->shouldReceive('is')->andReturn(false);
        $this->assertEquals('', $this->item->getState());

        $this->item->isActiveWhen(true);
        $this->assertEquals('active', $this->item->getState());
    }
}

function url()
{
    return 'localhost';
}

function route()
{
    return 'localhost/route';
}
