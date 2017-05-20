<?php

namespace Twitch;

/**
 * Class Channel
 * @package Twitch
 * @method bool mature()
 * @method bool partner()
 * @method string status()
 * @method string broadcaster_language()
 * @method string display_name()
 * @method string game()
 * @method string language()
 * @method int _id()
 * @method string name()
 * @method string created_at()
 * @method string updated_at()
 * @method mixed delay()
 * @method string logo()
 * @method bool|mixed banner()
 * @method string video_banner()
 * @method string background()
 * @method string profile_banner()
 * @method string profile_banner_background_color()
 * @method string url()
 * @method int views()
 * @method int followers()
 */
class Channel extends AbstractResource
{

    /**
     * @return \DateTime
     */
    function updatedAt()
    {
        return new \DateTime($this->updated_at(), new \DateTimeZone('GMT'));
    }

    /**
     * @return \DateTime
     */
    function createdAt()
    {
        return new \DateTime($this->created_at(), new \DateTimeZone('GMT'));
    }
}