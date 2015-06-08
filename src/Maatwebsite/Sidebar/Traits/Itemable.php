<?php

namespace Maatwebsite\Sidebar\Traits;

use Closure;
use Illuminate\Support\Collection;
use ReflectionFunction;

trait Itemable {

    /**
     * @var Collection
     */
    public $items;

    /**
     * Add an item to the group
     * @param         $name
     * @param Closure $callback
     * @return MenuItem
     */
    public function addItem($name, Closure $callback = null)
    {
        $item = $this->getItem()->init($name);

        if ( $callback && $callback instanceof Closure )
        {
            $parameters = $this->resolveMethodDependencies(
                ['item' => $item], new ReflectionFunction($callback)
            );

            call_user_func_array($callback, $parameters);
        }

        // Add the new item to the array
        if ( !empty($item) )
            $this->items->push($item);

        // Return the item object
        return $item;
    }

    /**
     * Check if we have items
     * @return bool
     */
    public function hasItems()
    {
        return count($this->items) > 0 ? true : false;
    }

    /**
     * Get all items
     * @return array
     */
    public function getItems()
    {
        return $this->items->sortBy('weight');
    }
}
