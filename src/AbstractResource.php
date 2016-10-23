<?php

namespace Twitch;

/**
 * Class AbstractResource
 * @package Twitch
 */
abstract class AbstractResource
{
    protected $data = [];
    protected $casts = [
        'channel' => Channel::class
    ];

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

        return $instance;
    }

    protected function parseProperties(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->parse($key, $value);
        }
    }

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

        return $this;
    }

    protected function get($key = null)
    {
        if($key === null)
        {
            return $this->data;
        }

        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function __call($name, $arguments)
    {
        if($data = $this->get($name))
        {
            return $data;
        }
    }
}