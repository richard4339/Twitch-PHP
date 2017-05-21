<?php

namespace Twitch;

use Twitch\Exceptions\APIVersionException;
use Twitch\Exceptions\GetException;
use Twitch\Object\Stream;
use Twitch\Object\User;

/**
 * Class BaseTwitch
 * @package Twitch
 * @version 1.0.6
 */
class BaseTwitch extends Base
{

    /**
     * Gets a an array of Stream objects
     * Valid on API Version 5
     * @param array|string|int $param An array of streamer ID numbers. Twitch defines these as numbers but says to treat them as strings.
     * @return Stream[]
     * @throws GetException
     * @throws APIVersionException
     * @since 1.0.0
     */
    function getStreamsV5($param)
    {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getStreamsV5() is only valid on API Version 5");
        }

        if(empty($param)) {
            throw new GetException('No streams provided');
        }

        if(!is_array($param))
        {
            $param = array((string)$param);
        }

        $params = implode(',', $param);

        $url = $this->_buildRequestString('streams', ['channel' => $params]);

        $response = $this->request($url);

        return array_map(function ($item) {
            return Stream::makeFromArray($item);
        }, $response['streams']);
    }

    /**
     * Gets a an array of Stream objects
     * Valid on API Version 3
     * @param string[] $param An array of streamer names
     * @return Stream[]
     * @throws GetException
     * @throws APIVersionException
     * @deprecated 1.0.0
     */
    function getStreamsV3($param)
    {
        if($this->_apiVersion != 3) {
            throw new APIVersionException("getStreamsV3() is only valid on API Version 3");
        }

        if(count($param) < 1) {
            throw new GetException('No streams provided');
        }

        $params = implode(',', $param);

        $url = $this->_buildRequestString('streams', ['channel' => $params]);

        $response = $this->request($url);

        return array_map(function ($item) {
            return Stream::makeFromArray($item);
        }, $response['streams']);
    }

    /**
     * Gets an array of User objects
     * Valid on API Version 5
     * @param array|string $users
     * @return User[]
     * @throws APIVersionException
     * @throws GetException
     */
    function getUsersV5($users) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getUsers() is only valid on API Version 5");
        }

        if(empty($users)) {
            throw new GetException('No user(s) provided');
        }

        if(!is_array($users))
        {
            $users = array($users);
        }

        $params = implode(',', $users);

        $url = $this->_buildRequestString('users', ['login' => $params]);

        $response = $this->request($url);

        return array_map(function ($item) {
            return User::makeFromArray($item);
        }, $response['users']);
    }

    /**
     * Get a User object
     * Valid on API Version 5
     * @param string $user User's ID number
     * @return User
     * @throws APIVersionException
     * @throws GetException
     */
    function getUserByIDV5($user) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getUserByIDV5() is only valid on API Version 5");
        }

        if(empty($user)) {
            throw new GetException('No user provided');
        }

        $url = $this->_buildRequestString(sprintf('users/%s', $user));

        $response = $this->request($url);

        return User::makeFromArray($response);
    }

}