<?php

use Maatwebsite\Sidebar\Builder;
use Maatwebsite\Sidebar\Domain\DefaultBuilder;
use Mockery as m;

class DefaultBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var DefaultBuilder
     */
    protected $builder;

    protected function setUp()
    {
        $this->container = m::mock('Illuminate\Contracts\Container\Container');
        $this->builder   = new DefaultBuilder($this->container);
    }

    public function test_can_instantiate_new_builder()
    {
        $builder = new DefaultBuilder($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Builder', $builder);
    }

    public function test_can_have_custom_builders()
    {
        $builder = new StubBuilder($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Builder', $builder);
    }

    public function test_can_build_new_menu()
    {
        $this->mockContainerMake();

        $this->assertInstanceOf('Maatwebsite\Sidebar\Builder', $this->builder->build());
    }

    public function test_can_build_new_menu_with_closure()
    {
        $this->mockContainerMake();

        $this->builder->build(function ($menu) {
            $this->assertInstanceOf('Maatwebsite\Sidebar\Menu', $menu);
        });
    }

    public function test_can_continue_building_menu()
    {
        $this->mockContainerMake();

        $first  = $this->builder->build();
        $second = $this->builder->build();

        $this->assertEquals($first, $second);
        $this->assertInstanceOf('Maatwebsite\Sidebar\Builder', $second);
    }

    public function test_can_build_with_a_custom_menu()
    {
        $menu = m::mock('Maatwebsite\Sidebar\Menu');
        $this->builder->setMenu($menu);

        $builder = $this->builder->build();

        $this->assertInstanceOf('Maatwebsite\Sidebar\Builder', $builder);
        $this->assertEquals($menu, $builder->getMenu());
    }

    public function test_cannot_set_menu_when_already_set()
    {
        $this->setExpectedException('Maatwebsite\Sidebar\Exceptions\LogicException');

        $this->mockContainerMake();
        $this->builder->build();

        $this->builder->setMenu(m::mock('Maatwebsite\Sidebar\Menu'));
    }

    protected function mockContainerMake()
    {
        $this->container->shouldReceive('make')->with('Maatwebsite\Sidebar\Menu')->andReturn(
            m::mock('Maatwebsite\Sidebar\Menu')
        );
    }
}

class StubBuilder extends DefaultBuilder implements Builder
{
}
