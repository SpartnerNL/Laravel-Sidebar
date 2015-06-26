<?php

namespace Maatwebsite\Sidebar\Infrastructure;

class NullSidebarFlusher implements SidebarFlusher
{
    /**
     * Flush
     *
     * @param $name
     */
    public function flush($name)
    {
    }
}
