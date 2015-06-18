<?php

namespace Maatwebsite\Sidebar;

interface Append extends Authorizable, Routeable
{
    /**
     * @return null|string
     */
    public function getName();

    /**
     * @param null|string $name
     *
     * @return Append
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @param string $icon
     *
     * @return Badge
     */
    public function setIcon($icon);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     *
     * @return Item
     */
    public function setUrl($url);

    /**
     * @param       $route
     * @param array $params
     *
     * @return Item
     */
    public function route($route, $params = []);
}
