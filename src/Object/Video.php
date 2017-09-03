<?php

namespace Twitch\Object;


use Twitch\AbstractResource;

/**
 * Class Video
 * @package Twitch\Object
 *
 * @version 1.0.7 Fields as of September 3, 2017
 *
 * @property string $title
 * @property string $description
 * @property string $description_html
 * @property int $broadcast_id
 * @property string $archive
 * @property string $status
 * @property string $tag_list
 * @property int $views
 * @property string $url
 * @property string $language
 * @property string $created_at (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @property string $viewable
 * @property $viewable_at
 * @property string $published_at (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @property string $_id
 * @property string $recorded_at (UTC) format YYYY-MM-DD\THH:MM:SSZ
 * @property string $game
 * @property int $length
 */
class Video extends AbstractResource
{

    /**
     * @return \DateTime
     */
    function videoCreatedAt()
    {
        return new \DateTime($this->created_at, new \DateTimeZone(self::TIMEZONE));
    }

    /**
     * @return \DateTime
     */
    function videoPublishedAt()
    {
        return new \DateTime($this->published_at, new \DateTimeZone(self::TIMEZONE));
    }

    /**
     * @return \DateTime
     */
    function videoRecordedAt()
    {
        return new \DateTime($this->recorded_at, new \DateTimeZone(self::TIMEZONE));
    }
}