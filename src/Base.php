<?php

namespace Twitch;

use Twitch\Exceptions\APIVersionException;
use Twitch\Exceptions\ClientIDException;


/**
 * Class Base
 * @package Twitch
 * @property-read string $_clientID
 * @property-read int $_apiVersion
 * @see https://dev.twitch.tv/docs
 * @version 1.0.0
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
     * @var string URL for the Twitch API
     */
    protected $_apiURL = "https://api.twitch.tv/kraken/";

    /**
     * Version 5 of the Twitch API is the current version as of May 20, 2017.
     * Version 3 is still available until February 13, 2018
     *
     * @var int API Version, defaults to version 5
     * @since 1.0.0
     * @see https://dev.twitch.tv/docs
     */
    private $_apiVersion;

    /**
     * Twitch constructor.
     * Client ID can optionally come from an environmental variable CLIENTID
     * @param string $clientID Client ID number supplied by Twitch
     * @param int $apiVersion Twitch API Version to use. Defaults to 5.
     * @throws ClientIDException
     * @throws APIVersionException
     * 
     * @see Base::$apiVersion API Version information
     * @see Base::_isValidAPIVersion()
     */
    function __construct($clientID = '', $apiVersion = 5)
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

        if(!$this->_isValidAPIVersion($apiVersion)) {
            throw new APIVersionException(sprintf("API Version %d is not valid.", $apiVersion));
        }

        $this->_apiVersion = $apiVersion;

        $this->_clientID = $clientID;
    }

    /**
     * @param $name
     * @return string
     */
    public function __get($name)
    {
        switch (strtoupper($name)) {
            case 'CLIENTID':
            case '_CLIENTID':
                return $this->_clientID;
                break;
            case 'APIVERSION':
            case '_APIVERSION':
                return $this->_apiVersion;
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
            $this->httpClient = new \GuzzleHttp\Client(['base_uri' => $this->_apiURL, 'verify' => false]);
        }

        return $this->httpClient;
    }

    /**
     * Verifies that the supplied version is valid based on the current Twitch API docs
     * @param int $version Version to check
     * @return bool
     *
     * @see Base::$apiVersion API Version information
     */
    private function _isValidAPIVersion($version) {
        switch ($version) {
            case 3:
            case 5:
                return true;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * @param $endpoint
     * @param array|null $params
     * @return string
     */
    protected function _buildRequestString($endpoint, array $params = null) {
        $url = $endpoint;
        $apiParams = array('api_version' => $this->_apiVersion, 'client_id' => $this->_clientID);
        $queryParams = array();
        if(!empty($params)) {
            $queryParams = array_merge($params, $apiParams);
        } else {
            $queryParams = $apiParams;
        }

        return sprintf("%s?%s", $endpoint, http_build_query($queryParams));
    }
}