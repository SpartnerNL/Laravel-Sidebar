<?php

namespace Maatwebsite\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Traits\AuthorizableTrait;
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Maatwebsite\Sidebar\Traits\CallableTrait;
use Serializable;

class DefaultBadge implements Badge, Serializable
{
    use CallableTrait, CacheableTrait, AuthorizableTrait;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * @var string
     */
    protected $class = 'badge badge-default';

    /**
     * @var array
     */
    protected $cacheables = [
        'value',
        'class'
    ];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return Badge
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return Badge
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    public function __serialize():array
    {
        return [
            'value' => $this->value,
            'class' => $this->class,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->value = $data['value'];
        $this->class = $data['class'];
    }
}
