<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Illuminate\Contracts\Cache\Repository as Cache;

class UserBasedSidebarFlusher implements SidebarFlusher
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
        if ((new SupportsCacheTags())->isSatisfiedBy($this->cache)) {
            $this->cache->tags(CacheKey::get($name))->flush();
        }
    }
}
