<?php

class TwitchTest extends PHPUnit_Framework_TestCase
{

    public function testSuppliedClientID()
    {

        $twitch = new \Twitch\Twitch('ABC123');

        $this->assertNotEmpty($twitch->_clientID);

    }

    public function testEnvironmentalClientID()
    {

        $twitch = new \Twitch\Twitch();

        $this->assertNotEmpty($twitch->_clientID);

    }

}
