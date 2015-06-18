<?php

use Maatwebsite\Sidebar\Infrastructure\StaticBuilderCacheDecorator;
use Mockery as m;

class StaticBuilderCacheDecoratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Maatwebsite\Sidebar\Domain\DefaultBuilder
     */
    protected $builder;

    /**
     * @var Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * @var Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var StaticBuilderCacheDecorator
     */
    protected $decorator;

    protected function setUp()
    {
        $this->builder = m::mock('Maatwebsite\Sidebar\Domain\DefaultBuilder');
        $this->builder->shouldReceive('setMenu');

        $this->cache   = m::mock('Illuminate\Cache\CacheManager');
        $this->config  = m::mock('Illuminate\Contracts\Config\Repository');
        $this->config->shouldReceive('get')
            ->with('sidebar.cache.duration', 1440)
            ->andReturn(1440);

        $this->decorator = new StaticBuilderCacheDecorator(
            $this->builder,
            $this->cache,
            $this->config
        );
    }

    public function test_menu_gets_cached()
    {
        $menu = m::mock('Maatwebsite\Sidebar\Menu');

        $this->cache->shouldReceive('has')->andReturn(true);
        $this->cache->shouldReceive('remember')->andReturn(
            $menu
        );

        $this->assertEquals($menu, $this->decorator->build());
    }
}
