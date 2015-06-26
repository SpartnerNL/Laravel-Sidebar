<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Illuminate\Contracts\Cache\Repository as Cache;

class StaticSidebarFlusher implements SidebarFlusher
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Flush
     *
     * @param $name
     */
    public function flush($name)
    {
        $this->cache->forget(CacheKey::get($name));
    }
}
