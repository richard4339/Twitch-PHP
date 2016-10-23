<?php

namespace Twitch;
use Twitch\Exceptions\GetException;

/**
 * Class Twitch
 * @package Twitch
 */
class Twitch extends Base
{

    /**
     * @param string[] $param An array of streamer names
     * @return Stream[]
     * @throws GetException
     */
    function getStreams($param)
    {

        if(count($param) < 1) {
            throw new GetException('No streams provided');
        }

        $params = implode(',', $param);

        $response = $this->request("streams?channel={$params}&client_id=" . $this->_clientID);

        return array_map(function ($item) {
            return Stream::makeFromArray($item);
        }, $response['streams']);
    }

}