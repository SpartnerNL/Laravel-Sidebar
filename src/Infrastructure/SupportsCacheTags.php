<?php

namespace Maatwebsite\Sidebar\Infrastructure;

use Illuminate\Contracts\Cache\Repository;
use Maatwebsite\Sidebar\Exceptions\CacheTagsNotSupported;

class SupportsCacheTags
{
    /**
     * @param Repository $repository
     *
     * @throws CacheTagsNotSupported
     * @return bool
     */
    public function isSatisfiedBy(Repository $repository)
    {
        if (!method_exists($repository->getStore(), 'tags')) {
            throw new CacheTagsNotSupported('Cache tags are necessary to use this kind of caching. Consider using a different caching method');
        }

        return true;
    }
}
