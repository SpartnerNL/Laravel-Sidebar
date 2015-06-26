<?php

namespace Maatwebsite\Sidebar\Infrastructure;

interface SidebarFlusher
{
    /**
     * Flush
     *
     * @param $name
     */
    public function flush($name);
}
