<?php

namespace Maatwebsite\Sidebar\Presentation;

use Illuminate\Support\Facades\Request;
use Maatwebsite\Sidebar\Item;

class ActiveStateChecker
{
    /**
     * @param Item $item
     *
     * @return bool
     */
    public function isActive(Item $item)
    {
        // Check if one of the children is active
        foreach ($item->getItems() as $child) {
            if ($this->isActive($child)) {
                return true;
            }
        }

        // Custom set active path
        if ($path = $item->getActiveWhen()) {
            return Request::is(
                $path
            );
        }

        if($route = $item->getRoute()) {
            return $this->getPartialRoute(Request::route()->getName()) === $this->getPartialRoute($route);
        }

        $path = ltrim(str_replace(url('/'), '', $item->getUrl()), '/');

        return Request::is(
            $path,
            $path . '/*'
        );
    }

    protected function getPartialRoute($route, $delimiter = '.', $parts = 2)
    {
        $route = explode($delimiter, $route);
        $routeParts = [];

        for($part = 0; $part < $parts; $part++) {
            $routeParts[] = $route[$part];
        }

        return implode($delimiter, $routeParts);
    }
}
