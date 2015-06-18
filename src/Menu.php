<?php

namespace Maatwebsite\Sidebar;

use Closure;
use Illuminate\Support\Collection;

interface Menu
{
    /**
     * @param          $name
     * @param callable $callback
     *
     * @return Group
     */
    public function group($name, Closure $callback = null);

    /**
     * @param Group $group
     *
     * @return $this
     */
    public function addGroup(Group $group);

    /**
     * @return Collection|Group[]
     */
    public function getGroups();

    /**
     * @param Menu $menu
     *
     * @return mixed
     */
    public function add(Menu $menu);
}
