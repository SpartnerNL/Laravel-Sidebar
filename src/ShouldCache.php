<?php

namespace Maatwebsite\Sidebar;

use Serializable;

interface ShouldCache extends Serializable
{
    /**
     * @return array
     */
    public function getCacheables();
}
