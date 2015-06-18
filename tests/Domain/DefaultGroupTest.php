<?php

use Maatwebsite\Sidebar\Domain\DefaultGroup;
use Maatwebsite\Sidebar\Group;
use Mockery as m;

class DefaultGroupGroupTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var DefaultGroup
     */
    protected $group;

    protected function setUp()
    {
        $this->container = m::mock('Illuminate\Contracts\Container\Container');
        $this->group = new DefaultGroup($this->container);
    }

    public function test_can_instantiate_new_group()
    {
        $group = new DefaultGroup($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Group', $group);
    }

    public function test_can_have_custom_groups()
    {
        $group = new StubGroup($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Group', $group);
    }

    public function test_group_can_be_cached()
    {
        $serialized = serialize($this->group);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Group', $unserialized);
        $this->assertInstanceOf('Illuminate\Support\Collection', $unserialized->getItems());

        // TODO: check if items are added
        $this->assertCount(0, $unserialized->getItems());
    }
}

class StubGroup extends DefaultGroup implements Group
{
}
