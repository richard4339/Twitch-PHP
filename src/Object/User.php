<?php

namespace Twitch\Object;

use Twitch\AbstractResource;

/**
 * Class User
 *
 * @package Twitch
 *
 * @version 1.0.4 Fields as of May 20, 2017
 *
 * @method string name()
 * @method string display_name()
 * @method string type()
 * @method string bio()
 * @method \DateTime created_at() (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @method \DateTime updated_at() (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @method string logo()
 *
 * @since 1.0.0
 */
class User extends AbstractResource
{

    /**
     * Returns the field _id
     * @return string
     */
    function id()
    {
        return $this->get('_id');
    }
}