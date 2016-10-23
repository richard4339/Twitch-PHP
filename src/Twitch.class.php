<?php

namespace Twitch;

/**
 * Class Twitch
 * @package Twitch
 *
 * @property-read string $_clientID
 */
class Twitch
{
    /**
     * @var \GuzzleHttp\Client $httpClient
     */
    protected $httpClient;

    /**
     * @var string Twitch Client ID
     */
    protected $_clientID;

    /**
     * Twitch constructor.
     * @param $clientID
     */
    function __construct($clientID = '')
    {
        if (empty($clientID)) {
            $clientID = $_ENV["CLIENTID"];
        }

        $this->_clientID = $clientID;
    }

    /**
     * @param $name
     * @return string
     */
    function __get($name)
    {
        switch (strtoupper($name)) {
            case 'CLIENTID':
            case '_CLIENTID':
                return $this->_clientID;
                break;
        }
    }

    /**
     * @param $url
     * @return array
     */
    function request($url)
    {
        $response = $this->getHttpClient()
            ->request('GET', $url);

        return ResponseMediator::convertResponseToArray($response);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = new \GuzzleHttp\Client(['base_uri' => 'https://api.twitch.tv/kraken/', 'verify' => false]);
        }

        return $this->httpClient;
    }

    /**
     * @param string[] $param
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