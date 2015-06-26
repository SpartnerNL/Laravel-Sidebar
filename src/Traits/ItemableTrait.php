<?php

namespace Maatwebsite\Sidebar\Traits;

use Closure;
use Illuminate\Support\Collection;
use Maatwebsite\Sidebar\Item;

trait ItemableTrait
{
    /**
     * @var Collection|Item[]
     */
    protected $items;

    /**
     * Add a new Item (or edit an existing item) to the Group
     *
     * @param string   $name
     * @param callable $callback
     *
     * @return Item
     */
    public function item($name, Closure $callback = null)
    {
        if ($this->items->has($name)) {
            $item = $this->items->get($name);
        } else {
            $item = $this->container->make('Maatwebsite\Sidebar\Item');
            $item->name($name);
        }

        $this->call($callback, $item);

        $this->addItem($item);

        return $item;
    }

    /**
     * Add Item instance to Group
     *
     * @param Item $item
     *
     * @return Item
     */
    public function addItem(Item $item)
    {
        $this->items->put($item->getName(), $item);

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems()
    {
        return $this->items->sortBy(function (Item $item) {
            return $item->getWeight();
        });
    }

    /**
     * Check if we have items
     * @return bool
     */
    public function hasItems()
    {
        return count($this->items) > 0 ? true : false;
    }
}
