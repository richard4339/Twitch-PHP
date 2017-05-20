<?php

use Twitch\Twitch;

class TwitchTest extends PHPUnit_Framework_TestCase
{

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
