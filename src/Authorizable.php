<?php

namespace Maatwebsite\Sidebar;

interface Authorizable
{
    /**
     * Check if we are authorized to see this item/group
     * @return mixed
     */
    public function isAuthorized();

    /**
     * Authorize the group/item
     *
     * @param bool $state
     *
     * @return $this
     */
    public function authorize($state = true);
}
