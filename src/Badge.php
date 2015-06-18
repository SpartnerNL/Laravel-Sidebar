<?php

namespace Maatwebsite\Sidebar;

interface Badge extends Authorizable
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     *
     * @return Badge
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param string $class
     *
     * @return Badge
     */
    public function setClass($class);
}
