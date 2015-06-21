<?php

namespace Maatwebsite\Sidebar\Traits;

use Closure;
use Illuminate\Routing\RouteDependencyResolverTrait;
use ReflectionFunction;

trait CallableTrait
{
    use RouteDependencyResolverTrait;

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
        if ($callback instanceof Closure) {
            // Make dependency injection possible
            $parameters = $this->resolveMethodDependencies(
                [$caller], new ReflectionFunction($callback)
            );
            call_user_func_array($callback, $parameters);
        }

        return $caller;
    }
}
