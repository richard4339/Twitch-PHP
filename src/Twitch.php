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
 * @version 1.0.2
 */
class Twitch extends BaseTwitch
{
    /**
     * Gets a an array of Stream objects
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

}