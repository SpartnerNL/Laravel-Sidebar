<?php

namespace Maatwebsite\Sidebar;

interface Item extends Itemable
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     *
     * @return Item
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
}
