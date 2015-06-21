<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;

class StaticCacheResolver implements SidebarResolver
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var ContainerResolver
     */
    protected $resolver;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param ContainerResolver $resolver
     * @param Cache             $cache
     * @param Config            $config
     */
    public function __construct(ContainerResolver $resolver, Cache $cache, Config $config)
    {
        $this->cache    = $cache;
        $this->resolver = $resolver;
        $this->config   = $config;
    }

    /**
     * @param $name
     *
     * @return Sidebar
     */
    public function resolve($name)
    {
        $duration = $this->config->get('sidebar.cache.duration');

        return $this->cache->remember(CacheKey::get($name), $duration, function () use ($name) {
            return $this->resolver->resolve($name);
        });
    }
}
