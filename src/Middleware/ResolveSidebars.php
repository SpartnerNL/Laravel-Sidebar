<?php

namespace Maatwebsite\Sidebar\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Maatwebsite\Sidebar\SidebarManager;

class ResolveSidebars implements Middleware
{
    /**
     * @var SidebarManager
     */
    protected $manager;

    /**
     * @param SidebarManager $manager
     */
    public function __construct(SidebarManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->manager->resolve();

        return $next($request);
    }
}
