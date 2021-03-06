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
 * @version 1.1.5
 */
class BaseTwitch extends Base
{

    /**
     * Gets a an array of Stream objects by Stream IDs or Logins. On or around 9/1/2017 Channel names are no longer supported.
     * This function will translate from names to channel IDs, but only if the first argument is not a number. This will
     * also add a minimum one second delay to prevent rate limiting.
     * Valid on API Version 5
     * @param array|string|int $param An array of streamer ID numbers. Twitch defines these as numbers but says to treat them as strings.
     * @return Stream[]
     * @throws GetException
     * @throws APIVersionException
     * @since 1.0.0
     * @deprecated 1.1.5
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

        if(!is_numeric($param[0])) {
            $param = $this->getUserIDsv5($param);

            // Let's stop for a second because rate limiting
            sleep(1);
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
     * @deprecated 1.1.5
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
     * Gets an array of User IDs
     * Valid on API Version 5
     * This function will always use the latest API version in the event of future breaking changes
     * @param array|string $users
     * @return int[]
     * @throws APIVersionException
     * @throws GetException
     * @since 1.1.3
     * @deprecated 1.1.5
     */
    function getUserIDsv5($users)
    {
        $return = array();
        foreach ($this->getUsersv5($users) as $i) {
            $return[] = $i->id();
        }

        return $return;
    }

    /**
     * Get a User object
     * Valid on API Version 5
     * @param string $user User's ID number
     * @return User
     * @throws APIVersionException
     * @throws GetException
     * @deprecated 1.1.5
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
     * @deprecated 1.1.5
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