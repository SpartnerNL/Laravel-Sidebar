<?php

namespace Maatwebsite\Sidebar\Traits;

trait Attributable {

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * return a clean instance
     */
    public function cleanInstance()
    {
        $instance = app(get_class($this));
        return $instance;
    }

    /**
     * Set attribute
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Get attribute
     * @param      $attribute
     * @param null $value
     * @return mixed|null
     * @internal param null $default
     */
    public function getAttribute($attribute, $value = null)
    {
        $value = $this->getRawAttribute($attribute, $value);

        if ( $this->hasMutator($attribute) )
        {
            return $this->mutate($attribute, $value);
        }

        return $value;
    }

    /**
     * Get the raw attribute value
     * @param      $attribute
     * @param mixed|null $value
     * @return null
     */
    public function getRawAttribute($attribute, $value = null)
    {
        if ( isset($this->attributes[$attribute]) )
            $value = $this->attributes[$attribute];

        return $value;
    }

    /**
     * Has mutator
     * @param $attribute
     * @return bool
     */
    public function hasMutator($attribute)
    {
        $method = $this->getMutateMethod($attribute);

        return method_exists($this, $method);
    }

    /**
     * Mutate the attribute value
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function mutate($attribute, $value)
    {
        $method = $this->getMutateMethod($attribute);

        return $this->{$method}($value);
    }

    /**
     * @param $attribute
     * @return string
     */
    protected function getMutateMethod($attribute)
    {
        return 'get' . studly_case($attribute);
    }

    /**
     * Magic setter
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function __set($attribute, $value)
    {
        return $this->setAttribute($attribute, $value);
    }

    /**
     * Magic getter
     * @param $attribute
     * @return mixed|null
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * Check if attribute isset
     * @param $attribute
     * @return mixed|null
     */
    public function __isset($attribute)
    {
        return isset($this->attributes[$attribute]) ? true : false;
    }

    /**
     * Magic call
     * @param $method
     * @param $params
     * @return Attributable
     */
    public function __call($method, $params)
    {
        return $this->setAttribute($method, head($params));
    }
}
