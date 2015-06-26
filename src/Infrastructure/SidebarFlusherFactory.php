<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Maatwebsite\Sidebar\Exceptions\SidebarFlusherNotSupported;

class SidebarFlusherFactory
{
    /**
     * @param $name
     *
     * @throws SidebarFlusherNotSupported
     * @return string
     */
    public static function getClassName($name)
    {
        if ($name) {
            $class = __NAMESPACE__ . '\\' . studly_case($name) . 'SidebarFlusher';

            if (class_exists($class)) {
                return $class;
            }

            throw new SidebarFlusherNotSupported('Chosen caching type is not supported. Supported: [static, user-based]');
        }

        return __NAMESPACE__ . '\\NullSidebarFlusher';
    }
}
