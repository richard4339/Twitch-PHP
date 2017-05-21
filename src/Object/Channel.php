<?php

namespace Twitch\Object;

use Twitch\AbstractResource;

/**
 * Class Channel
 *
 * @package Twitch
 *
 * @version 1.0.4 Fields as of May 20, 2017
 *
 * @method bool mature()
 * @method string status()
 * @method string broadcaster_language()
 * @method string display_name()
 * @method string game()
 * @method string language()
 * @method int _id()
 * @method string name()
 * @method string created_at() (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @method string updated_at() (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @method bool partner()
 * @method string logo()
 * @method bool|mixed banner()
 * @method string video_banner()
 * @method string background()
 * @method string profile_banner()
 * @method string profile_banner_background_color()
 * @method string url()
 * @method int views()
 * @method int followers()
 * @method string broadcast_type()
 * @method string description()
 *
 */
class Channel extends AbstractResource
{

    /**
     * @return \DateTime
     */
    function updatedAt()
    {
        return new \DateTime($this->updated_at(), new \DateTimeZone(self::TIMEZONE));
    }

    /**
     * @return \DateTime
     */
    function createdAt()
    {
        return new \DateTime($this->created_at(), new \DateTimeZone(self::TIMEZONE));
    }
}