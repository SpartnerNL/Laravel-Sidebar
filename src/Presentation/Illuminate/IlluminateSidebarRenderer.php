<?php

namespace Maatwebsite\Sidebar\Presentation\Illuminate;

use Illuminate\Contracts\View\Factory;
use Maatwebsite\Sidebar\Builder;
use Maatwebsite\Sidebar\Presentation\SidebarRenderer;

class IlluminateSidebarRenderer implements SidebarRenderer
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var string
     */
    protected $view = 'sidebar::menu';

    /**
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Builder $builder
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(Builder $builder)
    {
        $groups = [];
        foreach ($builder->getMenu()->getGroups() as $group) {
            $groups[] = (new IlluminateGroupRenderer($this->factory))->render($group);
        }

        return $this->factory->make($this->view, [
            'groups' => $groups
        ])->render();
    }
}
