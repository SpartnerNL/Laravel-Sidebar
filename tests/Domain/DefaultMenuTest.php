<?php

namespace Maatwebsite\Sidebar\Tests\Domain;

use Maatwebsite\Sidebar\Domain\DefaultGroup;
use Maatwebsite\Sidebar\Domain\DefaultMenu;
use Maatwebsite\Sidebar\Menu;
use Mockery as m;
use PHPUnit\Framework\TestCase as TestCase;

class DefaultMenuTest extends TestCase
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

    public function test_can_instantiate_new_menu()
    {
        $menu = new DefaultMenu($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Menu', $menu);
    }

    public function test_can_have_custom_menus()
    {
        $menu = new StubMenu($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Menu', $menu);
    }

    public function test_menu_can_be_cached()
    {
        $this->markTestSkipped("'Exception: Serialization of 'ReflectionClass' is not allowed'");
        $this->mockContainerMake();
        $this->menu->group('test');
        $this->menu->group('test2');

        $serialized   = serialize($this->menu);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Menu', $unserialized);
        $this->assertInstanceOf('Illuminate\Support\Collection', $unserialized->getGroups());
        $this->assertCount(2, $unserialized->getGroups());

    }

    public function test_can_add_group_instance_to_menu()
    {
        $group = new DefaultGroup($this->container);
        $group->name('test');

        $this->menu->addGroup($group);

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->menu->getGroups());
        $this->assertCount(1, $this->menu->getGroups());
        $this->assertEquals('test', $this->menu->getGroups()->first()->getName());
    }

    public function test_can_add_group_to_menu()
    {
        $this->mockContainerMake();

        $this->menu->group('test');

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->menu->getGroups());
        $this->assertCount(1, $this->menu->getGroups());
    }

    public function test_can_add_existing_group_to_menu_wont_duplicate()
    {
        $this->mockContainerMake('test');

        $this->menu->group('test');
        $this->menu->group('test');
        $this->menu->group('test');

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->menu->getGroups());
        $this->assertCount(1, $this->menu->getGroups());
    }

    public function test_get_groups_returns_sorted_groups()
    {
        $group = new DefaultGroup($this->container);
        $group->name('secondItem');
        $group->weight(2);

        $this->menu->addGroup($group);

        $group = new DefaultGroup($this->container);
        $group->name('firstItem');
        $group->weight(1);

        $this->menu->addGroup($group);

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->menu->getGroups());
        $this->assertCount(2, $this->menu->getGroups());

        $this->assertEquals('firstItem', $this->menu->getGroups()->first()->getName());
    }

    public function test_can_combined_menu_instances()
    {
        // Add group to original menu
        $group = new DefaultGroup($this->container);
        $group->name('existing');
        $group->weight(2);
        $this->menu->addGroup($group);

        // Init new menu
        $menu = new DefaultMenu($this->container);

        // Add a new one
        $group = new DefaultGroup($this->container);
        $group->name('new menu group');
        $group->weight(1);
        $menu->addGroup($group);

        // Append to existing
        $group = new DefaultGroup($this->container);
        $group->name('existing');
        $group->weight(2);
        $menu->addGroup($group);

        $this->menu->add($menu);

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->menu->getGroups());
        $this->assertCount(2, $this->menu->getGroups());

        $this->assertEquals('new menu group', $this->menu->getGroups()->first()->getName());
    }

    protected function mockContainerMake($name = null, $weight = null)
    {
        $mock = m::mock('Maatwebsite\Sidebar\Group');
        $mock->shouldReceive('name');
        $mock->shouldReceive('getName')->andReturn($name);
        $mock->shouldReceive('getWeight')->andReturn($weight);

        $this->container->shouldReceive('make')->with('Maatwebsite\Sidebar\Group')->andReturn(
            $mock
        );

        return $mock;
    }
}

class StubMenu extends DefaultMenu implements Menu
{
}
