<?php

namespace Maatwebsite\Sidebar;

interface Routeable
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     *
     * @return $this
     */
    public function url($url);

    /**
     * @return string
     */
    public function getRoute();

    /**
     * @param       $route
     * @param array $params
     *
     * @return $this
     */
    public function route($route, $params = []);
}
