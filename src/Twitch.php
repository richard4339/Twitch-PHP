<?php

namespace Twitch;

use Twitch\Exceptions\APIVersionException;
use Twitch\Exceptions\GetException;
use Twitch\Object\Stream;
use Twitch\Object\User;

/**
 * Class Twitch
 *
 * API specific functions are in Twitch\BaseTwitch for organization
 *
 * @package Twitch
 *
 * @version 1.1.4
 */
class Twitch extends BaseTwitch
{
    /**
     * Gets a an array of Stream objects by Stream IDs or Logins. On or around 9/1/2017 Channel names are no longer supported.
     * This function will translate from names to channel IDs, but only if the first argument is not a number. This will
     * also add a minimum one second delay to prevent rate limiting.
     * Valid on API Version 5
     * This function will always use the latest API version in the event of future breaking changes
     * @param array|string|int $param An array of streamer ID numbers. Twitch defines these as numbers but says to treat them as strings.
     * @return Stream[]
     * @throws GetException
     * @throws APIVersionException
     */
    function getStreams($param) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getStreams() [which calls getStreamsV5()] is only valid on API Version 5");
        }
        return $this->getStreamsV5($param);
    }

    /**
     * Gets an array of User objects
     * Valid on API Version 5
     * This function will always use the latest API version in the event of future breaking changes
     * @param array|string $users
     * @return User[]
     * @throws APIVersionException
     * @throws GetException
     */
    function getUsers($users) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getUsers() [which calls getUsersV5()] is only valid on API Version 5");
        }

        return $this->getUsersV5($users);
    }

    /**
     * Gets an array of User IDs
     * Valid on API Version 5
     * This function will always use the latest API version in the event of future breaking changes
     * @param array|string $users
     * @return int[]
     * @throws APIVersionException
     * @throws GetException
     * @since 1.1.3
     */
    function getUserIDs($users)
    {

        if($this->_apiVersion != 5) {
            throw new APIVersionException("getUsers() [which calls getUsersV5()] is only valid on API Version 5");
        }

        return $this->getUserIDsV5($users);
    }

    /**
     * Get a User object
     * Valid on API Version 5
     * @param string $user User's ID number
     * @return User
     * @throws APIVersionException
     * @throws GetException
     */
    function getUserByID($user) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getUserByID() [which calls getUserByIdV5()] is only valid on API Version 5");
        }

        return $this->getUserByIDV5($user);
    }

    /**
     * Get an array of Video objects
     * Valid on API Version 5
     * This function will always use the latest API version in the event of future breaking changes
     * @param $channelID
     * @param null $limit
     * @param null $offset
     * @param null $broadcastType
     * @param null $language
     * @param null $sort
     * @return static
     * @throws APIVersionException
     */
    function getChannelVideos($channelID, $limit = null, $offset = null, $broadcastType = null, $language = null, $sort = null) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getChannelVideos() [which calls getChannelVideosV5()] is only valid on API Version 5");
        }

        return $this->getChannelVideosV5($channelID, $limit, $offset, $broadcastType, $language, $sort);
    }

}