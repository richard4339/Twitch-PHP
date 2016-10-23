<?php

class TwitchTest extends PHPUnit_Framework_TestCase
{

    public function testCanUseEnvironmentalVariable()
    {
        $twitch = new \Twitch\Twitch();

        $this->assertNotEmpty($twitch->_clientID);
    }

}
