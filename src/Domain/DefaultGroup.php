<?php

namespace Maatwebsite\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Maatwebsite\Sidebar\Traits\CallableTrait;
use Serializable;

class DefaultGroup implements Group, Serializable
{
    use CallableTrait, CacheableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $weight = 0;

    /**
     * @var bool
     */
    protected $heading = true;

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
        'heading'
    ];

    /**
     * @param Container $container
     *
     * @internal param $name
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     *
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $weight
     *
     * @return Group
     */
    public function setWeight($weight)
    {
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
     * @param bool $hide
     *
     * @return Group
     */
    public function hideHeading($hide = true)
    {
        $this->heading = !$hide;

        return $this;
    }

    /**
     * @return bool
     */
    public function shouldShowHeading()
    {
        return $this->heading ? true : false;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems()
    {
        return [];
    }
}
