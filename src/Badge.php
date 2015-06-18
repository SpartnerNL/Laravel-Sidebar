<?php

namespace Maatwebsite\Sidebar;

interface Badge
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param string $class
     */
    public function setClass($class);
}
