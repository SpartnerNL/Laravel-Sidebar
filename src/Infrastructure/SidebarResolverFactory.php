<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Maatwebsite\Sidebar\Exceptions\SidebarResolverNotSupported;

class SidebarResolverFactory
{
    /**
     * @param $name
     *
     * @throws SidebarResolverNotSupported
     * @return string
     */
    public static function getClassName($name)
    {
        if ($name) {
            $class = __NAMESPACE__ . '\\' . studly_case($name) . 'CacheResolver';

            if (class_exists($class)) {
                return $class;
            }

            throw new SidebarResolverNotSupported('Chosen caching type is not supported. Supported: [static, user-based]');
        }

        return __NAMESPACE__ . '\\ContainerResolver';
    }
}
