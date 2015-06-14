<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Support\Collection;

interface Menu
{
    /**
     * @param Group $group
     *
     * @return Menu
     */
    public function addGroup(Group $group);

    /**
     * @return Collection|Group[]
     */
    public function getGroups();
}
