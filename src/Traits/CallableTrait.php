<?php

namespace Maatwebsite\Sidebar\Traits;

use Closure;

trait CallableTrait
{
    /**
     * Preform a callback on this workbook instance.
     *
     * @param callable $callback
     * @param null     $caller
     *
     * @return $this
     */
    public function call(Closure $callback = null, $caller = null)
    {
        if (is_callable($callback)) {
            call_user_func($callback, $caller ?: $this);
        }

        return $caller;
    }
}
