<?php

namespace Maatwebsite\Sidebar;

interface Item extends Itemable
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     *
     * @return Item $item
     */
    public function setName($name);

    /**
     * @param int $weight
     *
     * @return Item
     */
    public function setWeight($weight);

    /**
     * @return int
     */
    public function getWeight();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @param string $icon
     *
     * @return Item
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

    /**
     * @param callable|null|string $callbackOrValue
     * @param string|null          $className
     *                                              return Badge
     */
    public function badge($callbackOrValue = null, $className = null);

    /**
     * @param Badge $badge
     *
     * @return Badge
     */
    public function addBadge(Badge $badge);

    /**
     * @return Collection|Badge[]
     */
    public function getBadges();

    /**
     * @param callable|string|null $callbackOrUrl
     * @param string|null          $icon
     */
    public function append($callbackOrUrl = null, $icon = null);

    /**
     * @param Append $append
     *
     * @return Append
     */
    public function addAppend(Append $append);

    /**
     * @return Collection|Append[]
     */
    public function getAppends();
}
