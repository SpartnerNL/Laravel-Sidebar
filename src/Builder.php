<?php

namespace Maatwebsite\Sidebar;

use Closure;

interface Builder
{
    /**
     * @param callable $callback
     *
     * @return Builder
     */
    public function build(Closure $callback = null);

    /**
     * @return Menu|null
     */
    public function getMenu();

    /**
     * @param Menu $menu
     *
     * @return Builder
     */
    public function setMenu(Menu $menu);
}
