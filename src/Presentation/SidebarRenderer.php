<?php

namespace Maatwebsite\Sidebar\Presentation;

use Maatwebsite\Sidebar\Menu;

interface SidebarRenderer
{
    /**
     * @param Menu $menu
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(Menu $menu);
}
