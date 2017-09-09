<?php

namespace Twitch\Object;

use Twitch\AbstractResource;

/**
 * Class User
 *
 * @package Twitch
 *
 * @version 1.0.6 Fields as of May 20, 2017
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
class User extends AbstractResource implements \JsonSerializable
{

    /**
     * Returns the field _id
     * @return string
     */
    function id()
    {
        return $this->get('_id');
    }

    /**
     * @return \DateTime
     */
    function createdAt()
    {
        return new \DateTime($this->created_at(), new \DateTimeZone(self::TIMEZONE));
    }

    /**
     * @return \DateTime
     */
    function updatedAt()
    {
        return new \DateTime($this->updated_at(), new \DateTimeZone(self::TIMEZONE));
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $response = [
            'id' => $this->id(),
            'bio' => $this->bio(),
            'created_at' => $this->createdAt(),
            'display_name' => $this->display_name(),
            'logo' => $this->logo(),
            'name' => $this->name(),
            'type' => $this->type(),
            'updated_at' => $this->updatedAt(),
        ];

        return $response;
    }
}