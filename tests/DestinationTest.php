<?php

require_once "./src/classes/Destination.php";
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

final class DestinationTest extends TestCase
{
    public function testClassConstructor()
    {
        $destination = new Destination('747 La Sierra Ct., Waukesha, WI 53186');

        $this->assertSame('747 La Sierra Ct., Waukesha, WI 53186', $destination->address);
    }

    public function testGetStreetName()
    {
        $destination = new Destination('747 La Sierra Ct., Waukesha, WI 53186');
        $destination->getStreetName();
        $this->assertEquals('La Sierra Ct.', $destination->streetName);
    }

    public function testGetStreetNameLength()
    {
        $destination = new Destination('747 La Sierra Ct., Waukesha, WI 53186');
        $destination->getStreetName();
        $destination->getStreetNameLength();
        $this->assertEquals(13, $destination->streetNameLength);
    }
}