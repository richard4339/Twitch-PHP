<?php

namespace Twitch;

/**
 * Class Twitch
 * @package Twitch
 */
class Twitch extends Base
{

    /**
     * @param string[] $param An array of streamer names
     * @return Stream[]
     */
    function getStreams($param)
    {
        $params = implode(',', $param);

        $response = $this->request("streams?channel={$params}&client_id=" . $this->_clientID);

        return array_map(function ($item) {
            return Stream::makeFromArray($item);
        }, $response['streams']);
    }

}