<?php

namespace Maatwebsite\Sidebar;

use Closure;

interface Itemable
{
    /**
     * Add a new Item (or edit an existing item) to the Group
     *
     * @param string   $name
     * @param callable $callback
     *
     * @return Item
     */
    public function item($name, Closure $callback = null);

    /**
     * Add Item instance to Group
     *
     * @param Item $item
     *
     * @return Item
     */
    public function addItem(Item $item);

    /**
     * @return Collection|Item[]
     */
    public function getItems();

    /**
     * Check if we have items
     * @return bool
     */
    public function hasItems();
}
