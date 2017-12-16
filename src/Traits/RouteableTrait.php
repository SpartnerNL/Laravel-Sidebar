<?php

namespace Maatwebsite\Sidebar\Traits;

trait RouteableTrait
{
    /**
     * @var string
     */
    protected $url = '#';

    /**
     * @var string
     */
    protected $route = '';

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param       $route
     * @param array $params
     *
     * @return $this
     */
    public function route($route, $params = [])
    {
        $this->route = $route;

        $this->url(
            $this->container->make('url')->route($route, $params)
        );

        return $this;
    }
}
