<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Maatwebsite\Sidebar\Exceptions\CacheDecoratorNotSupported;

class BuilderCacheDecoratorFactory
{
    /**
     * @param $name
     *
     * @throws CacheDecoratorNotSupported
     * @return string
     */
    public static function getClassName($name)
    {
        $class = __NAMESPACE__ . '\\' . studly_case($name) . 'BuilderCacheDecorator';

        if (class_exists($class)) {
            return $class;
        }

        throw new CacheDecoratorNotSupported('Chosen caching type is not supported. Supported: [static, user-based]');
    }
}
