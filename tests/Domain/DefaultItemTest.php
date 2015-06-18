<?php

use Maatwebsite\Sidebar\Domain\DefaultBadge;
use Maatwebsite\Sidebar\Domain\DefaultItem;
use Maatwebsite\Sidebar\Item;
use Mockery as m;

class DefaultItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var DefaultItem
     */
    protected $item;

    protected function setUp()
    {
        $this->container = m::mock('Illuminate\Contracts\Container\Container');
        $this->item      = new DefaultItem($this->container);
    }

    public function test_can_instantiate_new_item()
    {
        $item = new DefaultItem($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Item', $item);
    }

    public function test_can_have_custom_items()
    {
        $item = new StubItem($this->container);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Item', $item);
    }

    public function test_can_set_name()
    {
        $this->item->setName('name');
        $this->assertEquals('name', $this->item->getName());
    }

    public function test_can_set_url()
    {
        $this->item->setUrl('url');
        $this->assertEquals('url', $this->item->getUrl());
    }

    public function test_can_set_icon()
    {
        $this->item->setIcon('icon');
        $this->assertEquals('icon', $this->item->getIcon());
    }

    public function test_can_set_weight()
    {
        $this->item->setWeight(1);
        $this->assertEquals(1, $this->item->getWeight());
    }

    public function test_item_can_be_cached()
    {
        $item = new DefaultItem($this->container);
        $this->item->addItem($item);

        $this->item->setName('name');
        $this->item->setIcon('icon');
        $this->item->setWeight(1);
        $this->item->setUrl('url');

        $serialized   = serialize($this->item);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf('Maatwebsite\Sidebar\Item', $unserialized);
        $this->assertInstanceOf('Illuminate\Support\Collection', $unserialized->getItems());
        $this->assertCount(1, $unserialized->getItems());
        $this->assertEquals('name', $unserialized->getName());
        $this->assertEquals('icon', $unserialized->getIcon());
        $this->assertEquals(1, $unserialized->getWeight());
        $this->assertEquals('url', $unserialized->getUrl());
    }

    public function test_can_add_a_badge_instance()
    {
        $item = new DefaultBadge($this->container);
        $item->setValue(1);
        $this->item->addBadge($item);

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->item->getBadges());
        $this->assertCount(1, $this->item->getBadges());
        $this->assertEquals('1', $this->item->getBadges()->first()->getValue());
    }

    public function test_can_add_a_badge()
    {
        $mock = $this->mockContainerMake();
        $mock->shouldReceive('setValue');
        $mock->shouldReceive('setClass');
        $mock->shouldReceive('getValue')->andReturn(1);
        $mock->shouldReceive('getClass')->andReturn('className');

        $this->item->badge(1, 'className');

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->item->getBadges());
        $this->assertCount(1, $this->item->getBadges());
        $this->assertEquals(1, $this->item->getBadges()->first()->getValue());
        $this->assertEquals('className', $this->item->getBadges()->first()->getClass());
    }

    protected function mockContainerMake()
    {
        $mock = m::mock('Maatwebsite\Sidebar\Badge');

        $this->container->shouldReceive('make')->with('Maatwebsite\Sidebar\Badge')->andReturn(
            $mock
        );

        return $mock;
    }
}

class StubItem extends DefaultItem implements Item
{
}
