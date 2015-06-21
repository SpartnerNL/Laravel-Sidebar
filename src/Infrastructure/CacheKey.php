<?php

namespace Maatwebsite\Sidebar\Infrastructure;

class CacheKey
{
    /**
     * @param      $name
     * @param null $id
     *
     * @return string
     */
    public static function get($name, $id = null)
    {
        if ($id) {
            $name .= '-' . $id;
        }

        return md5($name);
    }
}
