<?php

namespace Maatwebsite\Sidebar\Traits;

trait Routeable
{
    /**
     * @var string
     */
    protected $url = '#';

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
     * @return Item
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param       $route
     * @param array $params
     *
     * @return Item
     */
    public function route($route, $params = [])
    {
        $this->setUrl(
            $this->container->make('url')->route($route, $params)
        );

        return $this;
    }
}
