<?php

namespace Maatwebsite\Sidebar;

use Illuminate\Support\Collection;

interface Group extends Itemable, Authorizable
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     *
     * @return Group
     */
    public function name($name);

    /**
     * @param int $weight
     *
     * @return Group
     */
    public function weight($weight);

    /**
     * @return int
     */
    public function getWeight();

    /**
     * @param bool $hide
     *
     * @return Group
     */
    public function hideHeading($hide = true);

    /**
     * @return bool
     */
    public function shouldShowHeading();

    /**
     * @return Collection|Item[]
     */
    public function getItems();
}
