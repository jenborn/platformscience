<?php

require_once "./src/classes/Driver.php";
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

final class DriverTest extends TestCase
{
    public function testClassConstructor()
    {
        $driver = new Driver('Donnatella Moss');

        $this->assertSame('Donnatella Moss', $driver->driverName);
    }

    public function testProcessName()
    {
        $driver = new Driver('Donnatella Moss');
        $driver->processName();
        $this->assertEquals(5, $driver->vowels);
        $this->assertEquals(9, $driver->consonants);
    }

    public function testSetScore()
    {
        $driver = new Driver('Donnatella Moss');
        $driver->processName();
        $actualData = $driver->setScore();
        $expectedData = ['Donnatella Moss' => 
        ['nameLength' => 15, 
        'numVowels' => 5, 
        'numConsonants' => 9, 
        'vowelScore' => 5 * 1.5, 
        'consonantScore' => 9]];
        $this->assertEquals($expectedData, $actualData);
    }
}