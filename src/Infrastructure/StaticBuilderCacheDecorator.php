<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Closure;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Config\Repository;
use Maatwebsite\Sidebar\Builder;
use Maatwebsite\Sidebar\Menu;

class StaticBuilderCacheDecorator implements Builder
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var CacheManager
     */
    protected $cache;

    /**
     * @var int
     */
    protected $duration = 1440;

    /**
     * @param Builder      $builder
     * @param CacheManager $cache
     * @param Repository   $config
     */
    public function __construct(Builder $builder, CacheManager $cache, Repository $config)
    {
        $this->builder  = $builder;
        $this->cache    = $cache;
        $this->duration = $config->get('sidebar.cache.duration', 1440);
    }

    /**
     * @param callable $callback
     *
     * @return Builder
     */
    public function build(Closure $callback = null)
    {
        $cached = false;
        if ($this->cache->has($this->getCacheKey())) {
            $cached = true;
        }

        $menu = $this->cache->remember($this->getCacheKey(), $this->getCacheDuration(), function () use ($callback) {
            return $this->builder->build($callback);
        });

        // Make sure the cached Menu instance is present on the original builder object
        if ($cached) {
            $this->builder->setMenu($menu);
        }

        return $menu;
    }

    /**
     * @return Menu|null
     */
    public function getMenu()
    {
        return $this->cache->remember($this->getCacheKey(), $this->getCacheDuration(), function () {
            return $this->builder->getMenu();
        });
    }

    /**
     * @param Menu $menu
     *
     * @return Builder
     */
    public function setMenu(Menu $menu)
    {
        // If the menu was already cached, don't swap the instance
        if ($this->cache->has($this->getCacheKey())) {
            return $this->builder;
        }

        return $this->builder->setMenu($menu);
    }

    /**
     * @param null $affix
     *
     * @return string
     */
    protected function getCacheKey($affix = null)
    {
        return md5(get_class($this->builder) . $affix);
    }

    /**
     * @return int
     */
    protected function getCacheDuration()
    {
        return $this->duration;
    }

    /**
     * Render Sidebar to HTML
     * @return string
     */
    public function render()
    {
        return $this->builder->render();
    }
}
