<?php

namespace Maatwebsite\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Maatwebsite\Sidebar\Append;
use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Exceptions\LogicException;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Maatwebsite\Sidebar\Traits\CallableTrait;
use Maatwebsite\Sidebar\Traits\ItemableTrait;

class DefaultItem implements Item
{
    use CallableTrait, CacheableTrait, ItemableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $weight = 0;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Collection|Badge[]
     */
    protected $badges;

    /**
     * @var Collection|Append[]
     */
    protected $appends;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Data that should be cached
     * @var array
     */
    protected $cacheables = [
        'name',
        'weight',
        'url',
        'icon',
        'items',
        'badges',
        'appends'
    ];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->items     = new Collection();
        $this->badges    = new Collection();
        $this->appends   = new Collection();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Item $item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $weight
     *
     * @return Item
     */
    public function setWeight($weight)
    {
        if (!is_int($weight)) {
            throw new LogicException('Weight should be an integer');
        }

        $this->weight = $weight;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return Item
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Item
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param       $route
     * @param array $params
     *
     * @return Item
     */
    public function route($route, $params = [])
    {
        $this->setUrl(
            route($route, $params)
        );

        return $this;
    }

    /**
     * @param callable|null|string $callbackOrValue
     * @param string|null          $className
     *                                              return Badge
     */
    public function badge($callbackOrValue = null, $className = null)
    {
        // TODO: implement
    }

    /**
     * @param Badge $badge
     *
     * @return Badge
     */
    public function setBadge(Badge $badge)
    {
        $this->badges->push($badge);

        return $badge;
    }

    /**
     * @return Collection|Badge[]
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * @param callable|string|null $callbackOrUrl
     * @param string|null          $icon
     */
    public function append($callbackOrUrl = null, $icon = null)
    {
        // TODO: implement
    }

    /**
     * @param Append $append
     *
     * @return Append
     */
    public function setAppend(Append $append)
    {
        $this->appends->push($append);

        return $append;
    }

    /**
     * @return Collection|Append[]
     */
    public function getAppends()
    {
        return $this->appends;
    }
}
