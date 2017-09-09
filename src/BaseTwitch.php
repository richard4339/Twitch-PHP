<?php

namespace Twitch;

use Twitch\Exceptions\APIVersionException;
use Twitch\Exceptions\GetException;
use Twitch\Object\Stream;
use Twitch\Object\User;
use Twitch\Object\Video;

/**
 * Class BaseTwitch
 * @package Twitch
 * @version 1.0.6
 */
class BaseTwitch extends Base
{

    /**
     * Gets a an array of Stream objects by Stream IDs. On or around 9/1/2017 Channel names are no longer supported.
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

    /**
     * Get an array of Video objects
     *
     * @param int $channelID
     * @param int $limit
     * @param int $offset
     * @param string $broadcastType
     * @param string $language
     * @param null $sort
     * @return Video[]
     * @throws APIVersionException
     * @throws GetException
     *
     * @todo Add support for language and sort options
     */
    function getChannelVideosV5($channelID, $limit = null, $offset = null, $broadcastType = null, $language = null, $sort = null) {
        if($this->_apiVersion != 5) {
            throw new APIVersionException("getChannelVideosV5() is only valid on API Version 5");
        }

        if(empty($channelID)) {
            throw new GetException('No channel ID provided');
        }

        if(!is_integer($channelID)) {
            throw new GetException('Provided channel ID is not valid');
        }

        $params = array();

        if(!empty($broadcastType)) {
            if(!is_array($broadcastType)) {
                $broadcastType = array($broadcastType);
            }

            // archive, highlight, upload
            $broadcastTypes = array();
            if(in_array('archive', $broadcastType)) {
                $broadcastTypes[] = 'archive';
            }
            if(in_array('highlight', $broadcastType)) {
                $broadcastTypes[] = 'highlight';
            }
            if(in_array('upload', $broadcastType)) {
                $broadcastTypes[] = 'upload';
            }
            $params['broadcast_type'] = implode(',', $broadcastTypes);

        }

        if(!empty($limit) && is_integer($limit) && $limit >= 0) {
            if($limit > 100) {
                $limit = 100;
            }
            $params['limit'] = $limit;
        }

        if(!empty($offset) && is_integer($offset) && $offset >= 0) {
            $params['offset'] = $offset;
        }

        $url = $this->_buildRequestString(sprintf('channels/%d/videos', $channelID), $params);

        $response = $this->request($url);

        return array_map(function ($item) {
            return Video::makeFromArray($item);
        }, $response['videos']);
    }

}