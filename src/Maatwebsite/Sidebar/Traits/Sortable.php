<?php namespace Maatwebsite\Sidebar\Traits;

use Illuminate\Support\Collection;

trait Sortable {

    /**
     * @param Collection $collection
     * @param string     $key
     */
    public function order(Collection $collection, $key = 'weight')
    {
        if($collection)
        {
            $collection->sortBy(function($item) use($key)
            {
                return $item->{$key};
            });
        }
    }

}
