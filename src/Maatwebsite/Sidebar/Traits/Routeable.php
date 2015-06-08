<?php

namespace Maatwebsite\Sidebar\Traits;

trait Routeable
{

    /**
     * Set route
     * @param $route
     * @return $this
     */
    public function route($route)
    {
        return $this->setAttribute('route', route($route));
    }

    /**
     * Get the route
     * @param $value
     * @return string
     */
    public function getRoute($value)
    {
        // No need to have route, when we have children
        if ($this->hasItems()) {
            return '#';
        }

        if (! $value) {
            $value = route('acp.' . $this->getRawAttribute('name') . '.index');
        }

        return $value;
    }
}
