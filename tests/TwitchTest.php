<?php

use Twitch\Twitch;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

class TwitchTest extends PHPUnit_Framework_TestCase
{

    const TEST_STREAM_ID = 148018215;
    const TEST_USER = "misterrogers";

    public function testStreamNameWithValidStream()
    {

        $twitch = $this->createTwitch(__DIR__ . '/getstreamsv5valid.json');

        $streams = $twitch->getStreams([self::TEST_STREAM_ID]);

        $this->assertEquals("Mister Rogers' Neighborhood", $streams[0]->game());

    }

    public function testNoStreamsOnline()
    {

        $twitch = $this->createTwitch(__DIR__ . '/getstreamsv5nostreams.json');

        $streams = $twitch->getStreams([self::TEST_STREAM_ID]);

        $this->assertEquals(0, count($streams));

    }

    public function testGetUserGetID()
    {

        $twitch = $this->createTwitch(__DIR__ . '/getuservaliduser.json');

        $user = $twitch->getUser([self::TEST_USER]);

        $this->assertEquals((string)self::TEST_STREAM_ID, $user->_id());

    }

    /**
     * @param $responseFile
     * @return Twitch
     */
    public function createTwitch($responseFile) {


        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents($responseFile))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $twitch = new Twitch();
        $twitch->httpClient = $client;

        return $twitch;
    }

    public function testSuppliedClientID()
    {

        $twitch = new Twitch('FAKE');

        $this->assertNotEmpty($twitch->_clientID);

    }

    public function testEnvironmentalClientID()
    {

        $twitch = new Twitch();

        $this->assertNotEmpty($twitch->_clientID);

    }

    public function testValidClientID() {

        $this->expectException(\Twitch\Exceptions\ClientIDException::class);

        $twitch = new Twitch('ABC123');
    }

    public function testGetStreamsNoStreams()
    {

        $this->expectException(\Twitch\Exceptions\GetException::class);

        $twitch = new Twitch('FAKE');

        $twitch->getStreams([]);
    }

    /**
     * @deprecated 1.0.1
     */
    public function testGetStreamsNoStreamsV3()
    {

        $this->expectException(\Twitch\Exceptions\GetException::class);

        $twitch = new Twitch('FAKE', 3);

        $twitch->getStreamsV3([]);
    }

    /**
     * @since 1.0.1
     */
    public function testGetStreamsNoStreamsV5()
    {

        $this->expectException(\Twitch\Exceptions\GetException::class);

        $twitch = new Twitch('FAKE', 5);

        $twitch->getStreamsV5([]);
    }

    public function testInvalidAPIVersion1()
    {

        $this->expectException(\Twitch\Exceptions\APIVersionException::class);

        $twitch = new Twitch('FAKE', 1);
    }

    public function testInvalidAPIVersion2()
    {

        $this->expectException(\Twitch\Exceptions\APIVersionException::class);

        $twitch = new Twitch('FAKE', 2);
    }

    public function testInvalidAPIVersion4()
    {

        $this->expectException(\Twitch\Exceptions\APIVersionException::class);

        $twitch = new Twitch('FAKE', 4);
    }

    public function testInvalidAPIVersion6()
    {

        $this->expectException(\Twitch\Exceptions\APIVersionException::class);

        $twitch = new Twitch('FAKE', 6);
    }

}
