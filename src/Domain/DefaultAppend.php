<?php

namespace Maatwebsite\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\Append;
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Maatwebsite\Sidebar\Traits\CallableTrait;
use Maatwebsite\Sidebar\Traits\Routeable;
use Serializable;

class DefaultAppend implements Append, Serializable
{
    use CallableTrait, CacheableTrait, Routeable;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string|null
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $icon = 'fa fa-plus';

    /**
     * @var array
     */
    protected $cacheables = [
        'name',
        'url',
        'icon'
    ];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return Append
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return Badge
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }
}
