<?php

namespace Twitch;

use Twitch\Object\Channel;

/**
 * Class AbstractResource
 *
 * @package Twitch
 *
 * @version 1.0.6
 *
 * @method postMakeFromArray()
 */
abstract class AbstractResource
{
    protected $data = [];
    protected $casts = [];

    const TIMEZONE = 'GMT';

    /**
     * AbstractResource constructor.
     */
    function __construct()
    {

    }

    /**
     * @param array $properties
     * @return static
     */
    public static function makeFromArray(array $properties)
    {
        $instance = new static;

        $instance->parseProperties($properties);

        // Callback-style function to perform actions after all properties have been passed
        $instance->postMakeFromArray();

        return $instance;
    }

    /**
     * @param array $properties
     */
    protected function parseProperties(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->parse($key, $value);
        }
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    protected function parse($key, $value)
    {
        if ($this->isCastable($key)) {
            return $this->cast($key, $value);
        }

        return $this->setRawProperty($key, $value);
    }

    /**
     * @param $key
     * @return bool
     */
    protected function isCastable($key)
    {
        return array_key_exists($key, $this->casts) || is_int($key);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function cast($key, $value)
    {
        $class = is_int($key) ? $this->casts['all'] : $this->casts[$key];

        return $this->setRawProperty($key, $class::makeFromArray($value));
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function setRawProperty($key, $value)
    {
        $this->data[$key] = $value;

        // Automatically set the class variable if it exists
        if (property_exists(static::class, $key)) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * @param mixed|null $key
     * @param mixed|null $default
     * @return array|mixed|null
     */
    protected function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->data ?? $default;
        }

        return $this->data[$key] ?? $default;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return array|mixed|null
     */
    public function __call($name, $arguments)
    {
        if($data = $this->get($name))
        {
            return $data;
        }
    }
}