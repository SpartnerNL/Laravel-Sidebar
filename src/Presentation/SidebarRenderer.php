<?php

namespace Maatwebsite\Sidebar\Presentation;

use Maatwebsite\Sidebar\Builder;

interface SidebarRenderer
{
    /**
     * @param Builder $builder
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(Builder $builder);
}
