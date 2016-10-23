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

        $twitch = new Twitch();

        $twitch->getStreams([]);
    }

}
