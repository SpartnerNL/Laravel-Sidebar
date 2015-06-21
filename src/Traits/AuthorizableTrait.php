<?php

namespace Maatwebsite\Sidebar\Traits;

trait AuthorizableTrait
{
    /**
     * @var bool
     */
    protected $authorized = true;

    /**
     * Check if we are authorized to see this item/group
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

    /**
     * Authorize the group/item
     *
     * @param bool $state
     *
     * @return $this
     */
    public function authorize($state = true)
    {
        $this->authorized = $state;

        return $this;
    }
}
