<?php

namespace Twitch\Object;

use Twitch\AbstractResource;

/**
 * Class User
 * @package Twitch
 * @method string name()
 * @method string display_name()
 * @method string type()
 * @method string bio()
 * @method \DateTime created_at()
 * @method \DateTime updated_at()
 * @method string logo()
 *
 *  (UTC) format YYYY-MM-DD\THH:MM:SSZ
 */
class User extends AbstractResource
{

    /**
     * Returns the field _id
     * @return string
     */
    function id()
    {
        return $this->_id();
    }
}