<?php

namespace Maatwebsite\Sidebar\Tests\Traits;

use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\Routeable;
use Maatwebsite\Sidebar\Traits\RouteableTrait;
use Mockery as m;
use PHPUnit\Framework\TestCase as TestCase;

class RouteableTraitTest extends TestCase
{
    /**
     * @var Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var StubItemableClass
     */
    protected $routeable;

    protected function setUp(): void
    {
        $this->container = m::mock('Illuminate\Contracts\Container\Container');
        $this->routeable = new StubRouteableClass($this->container);
    }

    public function test_can_set_url()
    {
        $this->routeable->url('url');

        $this->assertEquals('url', $this->routeable->getUrl());
    }

    public function test_can_set_route()
    {
        $urlMock = m::mock('Illuminate\Contracts\Routing\UrlGenerator');
        $urlMock->shouldReceive('route')->andReturn('url');

        $this->container->shouldReceive('make')->andReturn($urlMock);

        $this->routeable->route('route');

        $this->assertEquals('url', $this->routeable->getUrl());
    }
}

class StubRouteableClass
{
    use RouteableTrait;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
