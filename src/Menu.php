<?php

namespace Maatwebsite\Sidebar;

use Closure;
use Illuminate\Support\Collection;

interface Menu extends Authorizable
{
    /**
     * Init a new group or call an existing group and add it to the menu
     *
     * @param          $name
     * @param callable $callback
     *
     * @return Group
     */
    public function group($name, Closure $callback = null);

    /**
     * Add a Group instance to the Menu
     *
     * @param Group $group
     *
     * @return $this
     */
    public function addGroup(Group $group);

    /**
     * Get collection of Group instances sorted by their weight
     * @return Collection|Group[]
     */
    public function getGroups();

    /**
     * Add another Menu instance and combined the two
     * Groups with the same name get combined, but
     * inherit each other's items
     *
     * @param Menu $menu
     *
     * @return Menu $menu
     */
    public function add(Menu $menu);
}
