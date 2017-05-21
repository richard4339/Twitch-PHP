<?php

namespace Twitch\Object;

use Twitch\AbstractResource;

/**
 * Class Stream
 *
 * @package Twitch
 *
 * @version 1.0.4 Fields as of May 20, 2017
 *
 * @method int _id()
 * @method string game()
 * @method string broadcast_platform()
 * @method string community_id()
 * @method int viewers()
 * @method int video_height()
 * @method float average_fps()
 * @method int|float|mixed delay()
 * @method string created_at() (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @method bool is_playlist()
 * @method string string_type()
 * @method Preview preview()
 * @method Channel channel()
 */
class Stream extends AbstractResource
{

    /**
     * @var string $name Name of the channel
     */
    public $name;

    /**
     * @var array $casts Castable classes included
     */
    protected $casts = [
        'channel' => Channel::class,
        'preview' => Preview::class
    ];

    /**
     * @return \DateTime
     */
    function streamStartedAt()
    {
        return new \DateTime($this->created_at(), new \DateTimeZone(self::TIMEZONE));
    }

    // Channel functions

    /**
     * @return bool
     */
    function mature()
    {
        return $this->channel()->mature();
    }

    /**
     * @return bool
     */
    function partner()
    {
        return $this->channel()->partner();
    }

    /**
     * @return string
     */
    function status()
    {
        return $this->channel()->status();
    }

    /**
     * @return string
     */
    function broadcaster_language()
    {
        return $this->channel()->broadcaster_language();
    }

    /**
     * @return string
     */
    function display_name()
    {
        return $this->channel()->display_name();
    }

    /**
     * @return string
     */
    function language()
    {
        return $this->channel()->language();
    }

    /**
     * @return string
     */
    function name()
    {
        return $this->channel()->name();
    }

    /**
     * @return \DateTime
     */
    function channelCreatedAt()
    {
        return $this->channel()->createdAt();
    }

    /**
     * @return false|int
     */
    function channelCreatedAtTime()
    {
        return $this->channel()->createdAtTime();
    }

    /**
     * @return \DateTime
     */
    function channelUpdatedAt()
    {
        return $this->channel()->updatedAt();
    }

    /**
     * @return false|int
     */
    function channelUpdatedAtTime()
    {
        return $this->channel()->updatedAtTime();
    }

    /**
     * @return string
     */
    function logo()
    {
        return $this->channel()->logo();
    }

    /**
     * @return bool|mixed
     */
    function banner()
    {
        return $this->channel()->banner();
    }

    /**
     * @return string
     */
    function video_banner()
    {
        return $this->channel()->video_banner();
    }

    /**
     * @return string
     */
    function background()
    {
        return $this->channel()->background();
    }

    /**
     * @return string
     */
    function profile_banner()
    {
        return $this->channel()->profile_banner();
    }

    /**
     * @return string
     */
    function profile_banner_background_color()
    {
        return $this->channel()->profile_banner_background_color();
    }

    /**
     * @return string
     */
    function url()
    {
        return $this->channel()->url();
    }

    /**
     * @return int
     */
    function views()
    {
        return $this->channel()->views();
    }

    /**
     * @return int
     */
    function followers()
    {
        return $this->channel()->followers();
    }

    /**
     * Set the name property after making the array for searching
     */
    public function postMakeFromArray()
    {
        parent::postMakeFromArray();

        $this->name = $this->name();
    }
}