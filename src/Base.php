<?php

namespace Twitch;

use Twitch\Exceptions\ClientIDException;


/**
 * Class Base
 * @package Twitch
 * @property-read string $_clientID
 */
class Base
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
     * Client ID can optionally come from an environmental variable CLIENTID
     * @param $clientID Client ID number supplied by Twitch
     * @throws ClientIDException
     */
    function __construct($clientID = '')
    {
        if (empty($clientID)) {
            $clientID = $_ENV["CLIENTID"];
        }

        if(empty($clientID)) {
            throw new ClientIDException("Client ID is not set");
        }

        // For unit tests
        if($clientID == "ABC123")
        {
            throw new ClientIDException("Client ID is invalid");
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
    protected function request($url)
    {
        $response = $this->getHttpClient()
            ->request('GET', $url);

        return ResponseMediator::convertResponseToArray($response);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = new \GuzzleHttp\Client(['base_uri' => 'https://api.twitch.tv/kraken/', 'verify' => false]);
        }

        return $this->httpClient;
    }
}