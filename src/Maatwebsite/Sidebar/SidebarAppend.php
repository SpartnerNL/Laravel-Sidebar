<?php namespace Maatwebsite\Sidebar;

use Illuminate\Contracts\View\Factory;
use Maatwebsite\Sidebar\Traits\Itemable;
use Maatwebsite\Sidebar\Traits\Routeable;
use Maatwebsite\Sidebar\Traits\Renderable;
use Maatwebsite\Sidebar\Traits\Attributable;
use Maatwebsite\Sidebar\Traits\Authorizable;

class SidebarAppend {

    /**
     * Traits
     */
    use Attributable, Renderable, Itemable, Routeable, Authorizable;

    /**
     * @var
     */
    protected $factory;

    /**
     * Default view
     * @var string
     */
    protected $view = 'acp::layouts.partials.sidebar.append';

    /**
     * @var string
     */
    protected $renderType = 'append';

    /**
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Init item
     * @return $this
     * @internal param $name
     */
    public function init()
    {
        return $this->cleanInstance();
    }
}
