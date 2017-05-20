<?php

namespace Twitch;

use Twitch\Exceptions\APIVersionException;
use Twitch\Exceptions\GetException;
use Twitch\Object\Stream;
use Twitch\Object\User;

/**
 * Class Twitch
 * @package Twitch
 * @version 1.0.0
 */
class Twitch extends Base
{

    /**
     * Gets a an array of Stream objects
     * Valid on API Version 3
     * @param string[] $param An array of streamer names
     * @return Stream[]
     * @throws GetException
     * @throws APIVersionException
     */
    function getStreams($param)
    {
        if($this->_apiVersion != 3) {
            throw new APIVersionException("getStreams() is only valid on API Version 3");
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
     * Gets the User object for a single user
     * Valid on API Version 5
     * @param $username
     * @return User
     * @throws APIVersionException
     * @throws GetException
     */
    function getUser($username) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getUser() is only valid on API Version 5");
        }

        if(empty($username)) {
            throw new GetException('No user provided');
        }

        $url = $this->_buildRequestString('users', ['login' => $username]);

        $response = $this->request($url);

        $users = array_map(function ($item) {
            return User::makeFromArray($item);
        }, $response['users']);

        return array_pop($users);
    }

    /**
     * Gets an array of Stream objects
     * Valid on API Version 3
     * @param string[] $param An array of streamer names
     * @return Stream[]
     * @throws GetException
     * @throws APIVersionException
     *
     * @todo Implement this method, it is currently not hitting the correct endpoint
     * @ignore Method not yet implemented and simply returns getStreams()
     */
    function getStreamsFollowed($param)
    {
        return $this->getStreams($param);
    }

}