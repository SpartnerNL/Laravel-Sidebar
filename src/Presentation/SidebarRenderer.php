<?php

namespace Maatwebsite\Sidebar\Presentation;

use Maatwebsite\Sidebar\Sidebar;

interface SidebarRenderer
{
    /**
     * @param Sidebar $sidebar
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(Sidebar $sidebar);
}
