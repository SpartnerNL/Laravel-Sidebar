<?php

namespace Maatwebsite\Sidebar\Tests\Domain;

use Maatwebsite\Sidebar\Domain\DefaultAppend;
use Maatwebsite\Sidebar\Domain\DefaultBadge;
use Maatwebsite\Sidebar\Domain\DefaultItem;
use Maatwebsite\Sidebar\Item;
use Mockery as m;
use PHPUnit\Framework\TestCase as TestCase;

class DefaultItemTest extends TestCase
{
    /**
     * @var Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var DefaultItem
     */
    protected $item;

    protected function setUp(): void
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
        $this->item->name('name');
        $this->assertEquals('name', $this->item->getName());
    }

    public function test_can_set_url()
    {
        $this->item->url('url');
        $this->assertEquals('url', $this->item->getUrl());
    }

    public function test_can_set_icon()
    {
        $this->item->icon('icon');
        $this->assertEquals('icon', $this->item->getIcon());
    }

    public function test_can_set_weight()
    {
        $this->item->weight(1);
        $this->assertEquals(1, $this->item->getWeight());
    }

    public function test_item_can_be_cached()
    {
        $item = new DefaultItem($this->container);
        $this->item->addItem($item);

        $this->item->name('name');
        $this->item->icon('icon');
        $this->item->weight(1);
        $this->item->url('url');

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
        $badge = new DefaultBadge($this->container);
        $badge->setValue(1);
        $this->item->addBadge($badge);

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->item->getBadges());
        $this->assertCount(1, $this->item->getBadges());
        $this->assertEquals('1', $this->item->getBadges()->first()->getValue());
    }

    public function test_can_add_a_badge()
    {
        $mock = $this->mockContainerMakeForBadge();
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

    public function test_can_add_a_append_instance()
    {
        $append = new DefaultAppend($this->container);
        $append->url('url');
        $this->item->addAppend($append);

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->item->getAppends());
        $this->assertCount(1, $this->item->getAppends());
        $this->assertEquals('url', $this->item->getAppends()->first()->getUrl());
    }

    public function test_can_add_a_append()
    {
        $mock = $this->mockContainerMakeForAppend();
        $mock->shouldReceive('route');
        $mock->shouldReceive('icon');
        $mock->shouldReceive('name');
        $mock->shouldReceive('getUrl')->andReturn('url');
        $mock->shouldReceive('getIcon')->andReturn('icon');
        $mock->shouldReceive('getName')->andReturn('name');

        $this->item->append('route', 'icon', 'name');

        $this->assertInstanceOf('Illuminate\Support\Collection', $this->item->getAppends());
        $this->assertCount(1, $this->item->getAppends());
        $this->assertEquals('url', $this->item->getAppends()->first()->getUrl());
        $this->assertEquals('icon', $this->item->getAppends()->first()->getIcon());
        $this->assertEquals('name', $this->item->getAppends()->first()->getName());
    }

    protected function mockContainerMakeForBadge()
    {
        $mock = m::mock('Maatwebsite\Sidebar\Badge');

        $this->container->shouldReceive('make')->with('Maatwebsite\Sidebar\Badge')->andReturn(
            $mock
        );

        return $mock;
    }

    protected function mockContainerMakeForAppend()
    {
        $mock = m::mock('Maatwebsite\Sidebar\Append');

        $this->container->shouldReceive('make')->with('Maatwebsite\Sidebar\Append')->andReturn(
            $mock
        );

        return $mock;
    }
}

class StubItem extends DefaultItem implements Item
{
}
