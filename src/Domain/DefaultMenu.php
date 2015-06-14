<?php

namespace Maatwebsite\Sidebar\Domain;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Maatwebsite\Sidebar\Traits\CallableTrait;
use Serializable;

class DefaultMenu implements Menu, Serializable
{
    use CallableTrait, CacheableTrait;

    /**
     * @var Collection|Group[]
     */
    protected $groups;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Data that should be cached
     * @var array
     */
    protected $cacheables = [
        'groups'
    ];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->groups = new Collection();
    }

    /**
     * @param          $name
     * @param callable $callback
     *
     * @return Group
     */
    public function group($name, Closure $callback = null)
    {
        if ($this->groups->contains($name)) {
            $group = $this->groups->get($name);
        } else {
            $group = $this->container->make('Maatwebsite\Sidebar\Group');
            $group->setName($name);
        }

        $this->call($callback, $group);

        $this->addGroup($group);

        return $group;
    }

    /**
     * @param Group $group
     *
     * @return $this
     */
    public function addGroup(Group $group)
    {
        $this->groups->put($group->getName(), $group);

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups()
    {
        return $this->groups->sortBy(function (Group $group) {
            return $group->getWeight();
        });
    }
}
