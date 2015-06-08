<?php

use Illuminate\Container\Container;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarManager;
use Mockery as m;

class SidebarManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SidebarManager
     */
    protected $manager;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var SidebarGroup
     */
    protected $group;

    public function setUp()
    {
        $this->container = m::mock(Container::class);
        $this->group     = m::mock(SidebarGroup::class);
        $this->group->shouldReceive('init')->andReturnSelf();

        $this->manager = new SidebarManager(
            $this->container,
            $this->group
        );
    }

    public function test_can_build_sidebar()
    {
        $this->assertInstanceOf(SidebarManager::class, $this->manager->build());
    }

    public function test_can_build_sidebar_in_closure()
    {
        $this->manager->build(function ($manager) {
            $this->assertInstanceOf(SidebarManager::class, $manager);
        });
    }

    public function test_can_build_a_group()
    {
        $this->group->shouldReceive('getAttribute')
                    ->with('name')
                    ->andReturn('1');

        $group = $this->manager->group('1');
        $this->assertInstanceOf(SidebarGroup::class, $group);
        $this->assertEquals('1', $group->name);
    }

    public function test_can_have_multiple_sidebars()
    {
        $this->assertInstanceOf(SidebarManager::class, (new StubSidebar1(
            $this->container,
            $this->group
        ))->build());

        $this->assertInstanceOf(SidebarManager::class, (new StubSidebar2(
            $this->container,
            $this->group
        ))->build());
    }

    public function test_can_disable_group_rendering()
    {
        $this->manager->withoutGroup();

        $this->assertTrue($this->manager->isWithoutGroupHeading());
    }

    public function test_manager_keeps_a_collection_of_groups()
    {
        $this->manager->group('1');
        $this->manager->group('2');

        $this->assertCount(2, $this->manager->getGroups());
    }

    public function test_manager_does_not_add_duplicate_groups()
    {
        $group1 = $this->manager->group('equal');
        $group2 = $this->manager->group('equal');

        $this->assertCount(1, $this->manager->getGroups());
        $this->assertEquals($group1, $group2);
    }

    public function test_manager_can_get_existing_group()
    {
        $group = $this->manager->group('1');

        $this->assertEquals($group, $this->manager->getGroup('1'));
    }

    public function test_manager_can_check_if_a_group_exists()
    {
        $this->assertFalse($this->manager->groupExists('1'));
        $this->manager->group('1');
        $this->assertTrue($this->manager->groupExists('1'));
    }
}

class StubSidebar1 extends SidebarManager
{
}

class StubSidebar2 extends SidebarManager
{
}
