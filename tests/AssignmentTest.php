<?php

require_once "./src/classes/Assignment.php";
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

final class AssignmentTest extends TestCase
{
    public function testSetDriversFile()
    {
        $assignment = new Assignment();
        $assignment->setDriversFile('drivers.csv');
        $this->assertSame('drivers.csv', $assignment->driversFile);
    }

    public function testSetDestinationsFile()
    {
        $assignment = new Assignment();
        $assignment->setDestinationsFile('destinations.csv');
        $this->assertSame('destinations.csv', $assignment->destinationsFile);
    }

    public function testHasCommonFactors()
    {
        $assignment = new Assignment();
        $actual = $assignment->hasCommonFactors(15,20);
        $expected = true;
        $this->assertEquals($expected, $actual, 'Common factors should be true');
    }
}