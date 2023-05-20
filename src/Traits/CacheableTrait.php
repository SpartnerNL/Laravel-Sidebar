<?php

namespace Maatwebsite\Sidebar\Traits;

trait CacheableTrait
{
    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize(): string
    {
        $cacheables = $this->__serialize();

        return serialize($cacheables);
    }

    public function __serialize(): array
    {
        $cacheables = [];
        foreach ($this->getCacheables() as $cacheable) {
            $cacheables[$cacheable] = $this->{$cacheable};
        }

        return $cacheables;
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized The string representation of the object.
     *
     * @return void
     */
    public function unserialize($serialized): void
    {
        $data = unserialize($serialized);

        $this->__unserialize($data);
    }

    public function __unserialize(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @return array
     */
    public function getCacheables()
    {
        return isset($this->cacheables) ? $this->cacheables : ['menu'];
    }
}
