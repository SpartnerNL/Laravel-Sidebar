<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Maatwebsite\Sidebar\Sidebar;

interface SidebarResolver
{
    /**
     * @param string $name
     *
     * @return Sidebar
     */
    public function resolve($name);
}
