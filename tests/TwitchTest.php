<?php

use Twitch\Twitch;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

/**
 * Class TwitchTest
 */
class TwitchTest extends PHPUnit_Framework_TestCase
{

    const TEST_STREAM_ID = 148018215;
    const TEST_USER = "misterrogers";

    /**
     * @expectedException \Twitch\Exceptions\ClientIDException
     */
    public function testInvalidClientID()
    {
        $twitch = $this->createTwitch(__DIR__ . '/invalidclientid.json', 400);

        $streams = $twitch->getStreams([self::TEST_STREAM_ID]);
    }

    /**
     *
     */
    public function testStreamNameWithValidStream()
    {
        $twitch = $this->createTwitch(__DIR__ . '/getstreamsv5valid.json');

        $streams = $twitch->getStreams([self::TEST_STREAM_ID]);

        $this->assertEquals("Mister Rogers' Neighborhood", $streams[0]->game());
    }

    /**
     *
     */
    public function testNoStreamsOnline()
    {
        $twitch = $this->createTwitch(__DIR__ . '/getstreamsv5nostreams.json');

        $streams = $twitch->getStreams([self::TEST_STREAM_ID]);

        $this->assertEquals(0, count($streams));
    }

    /**
     *
     */
    public function testGetUserGetID()
    {
        $twitch = $this->createTwitch(__DIR__ . '/getuservaliduser.json');

        $user = $twitch->getUser([self::TEST_USER]);

        $this->assertEquals((string)self::TEST_STREAM_ID, $user->_id());
    }

    /**
     *
     */
    public function testSuppliedClientID()
    {
        $twitch = new Twitch('FAKE');

        $this->assertNotEmpty($twitch->_clientID);
    }

    /**
     *
     */
    public function testEnvironmentalClientID()
    {
        $twitch = new Twitch();

        $this->assertNotEmpty($twitch->_clientID);
    }

    /**
     * @expectedException \Twitch\Exceptions\GetException
     */
    public function testGetStreamsNoStreams()
    {
        $twitch = new Twitch('FAKE');

        $twitch->getStreams([]);
    }

    /**
     * @expectedException \Twitch\Exceptions\GetException
     * @deprecated 1.0.1
     */
    public function testGetStreamsNoStreamsV3()
    {
        $twitch = new Twitch('FAKE', 3);

        $twitch->getStreamsV3([]);
    }

    /**
     * @since 1.0.1
     * @expectedException \Twitch\Exceptions\GetException
     */
    public function testGetStreamsNoStreamsV5()
    {
        $twitch = new Twitch('FAKE', 5);

        $twitch->getStreamsV5([]);
    }

    /**
     * @expectedException \Twitch\Exceptions\APIVersionException
     */
    public function testInvalidAPIVersion1()
    {
        new Twitch('FAKE', 1);
    }

    /**
     * @expectedException \Twitch\Exceptions\APIVersionException
     */
    public function testInvalidAPIVersion2()
    {
        new Twitch('FAKE', 2);
    }

    /**
     * @expectedException \Twitch\Exceptions\APIVersionException
     */
    public function testInvalidAPIVersion4()
    {
        new Twitch('FAKE', 4);
    }

    /**
     * @expectedException \Twitch\Exceptions\APIVersionException
     */
    public function testInvalidAPIVersion6()
    {
        new Twitch('FAKE', 6);
    }

    /**
     * Creates the Twitch class instance
     *
     * @param $responseFile
     * @param int $statusCode HTTP Response Code (Defaults to 200)
     * @return Twitch
     */
    public function createTwitch($responseFile, $statusCode = 200) {


        $mock = new MockHandler([
            new Response($statusCode, ['Content-Type' => 'application/json'], file_get_contents($responseFile))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $twitch = new Twitch();
        $twitch->httpClient = $client;

        return $twitch;
    }

}
