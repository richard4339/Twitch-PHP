<?php

namespace Twitch;


use GuzzleHttp\Psr7\Response;

/**
 * Class ResponseMediator
 * @package Twitch
 */
class ResponseMediator
{
    public static function convertResponseToArray(Response $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}