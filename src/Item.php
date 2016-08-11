<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Support\Collection;

interface Item extends Itemable, Authorizable, Routeable
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
    public function name($name);

    /**
     * @param int $weight
     *
     * @return Item
     */
    public function weight($weight);

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
    public function icon($icon);

    /**
     * @return string
     */
    public function getToggleIcon();

    /**
     * @param string $icon
     *
     * @return Item
     */
    public function toggleIcon($icon);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     *
     * @return Item
     */
    public function url($url);

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
     * @param null                 $name
     *
     * @return Append
     */
    public function append($callbackOrUrl = null, $icon = null, $name = null);

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

    /**
     * @param string $path
     *
     * @return $this
     */
    public function isActiveWhen($path);

    /**
     * @return string
     */
    public function getActiveWhen();

    /**
     * @param string $newTab
     *
     * @return $this
     */
    public function isNewTab($newTab);

    /**
     * @return bool
     */
    public function getNewTab();
}
