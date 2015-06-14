<?php

use Maatwebsite\Sidebar\Infrastructure\BuilderCacheDecoratorFactory;

class BuilderCacheDecoratorFactoryTest extends PHPUnit_Framework_TestCase
{
    public function test_if_returns_a_cache_decorator_class_name_when_static_is_given()
    {
        $this->assertEquals(
            'Maatwebsite\Sidebar\Infrastructure\StaticBuilderCacheDecorator',
            BuilderCacheDecoratorFactory::getClassName('static')
        );
    }

    public function test_if_returns_a_cache_decorator_class_name_when_user_based_is_given()
    {
        $this->assertEquals(
            'Maatwebsite\Sidebar\Infrastructure\UserBasedBuilderCacheDecorator',
            BuilderCacheDecoratorFactory::getClassName('user-based')
        );
    }

    public function test_it_throws_an_exception_on_not_supported_cache_type()
    {
        $this->setExpectedException('Maatwebsite\Sidebar\Exceptions\CacheDecoratorNotSupported');

        BuilderCacheDecoratorFactory::getClassName('non-existing');
    }
}
