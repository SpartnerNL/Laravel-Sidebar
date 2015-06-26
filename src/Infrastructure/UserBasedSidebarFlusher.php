<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Cache\Repository as Cache;

class UserBasedSidebarFlusher implements SidebarFlusher
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @param Cache $cache
     * @param Guard $guard
     */
    public function __construct(Cache $cache, Guard $guard)
    {
        $this->cache = $cache;
        $this->guard = $guard;
    }

    /**
     * Flush
     *
     * @param $name
     */
    public function flush($name)
    {
        $userId = $this->guard->check() ? $this->guard->user()->getAuthIdentifier() : null;

        $this->cache->forget(CacheKey::get($name, $userId));
    }
}
