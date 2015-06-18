<?php namespace Maatwebsite\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
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
        'items'
    ];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->items = new Collection();
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
}
