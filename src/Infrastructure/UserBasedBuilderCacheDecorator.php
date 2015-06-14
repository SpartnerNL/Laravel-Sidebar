<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Maatwebsite\Sidebar\Builder;

class UserBasedBuilderCacheDecorator extends StaticBuilderCacheDecorator implements Builder
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @param Builder      $builder
     * @param CacheManager $cache
     * @param Guard        $guard
     */
    public function __construct(Builder $builder, CacheManager $cache, Guard $guard, Repository $config)
    {
        $this->builder  = $builder;
        $this->cache    = $cache;
        $this->guard    = $guard;
        $this->duration = $config->get('sidebar.cache.duration', 1440);
    }

    /**
     * @param null $affix
     *
     * @return string
     */
    protected function getCacheKey($affix = null)
    {
        return parent::getCacheKey($this->guard->id());
    }
}
