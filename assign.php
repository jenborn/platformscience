<?php

/**
 * Assign drivers to destinations (1:1) based on Suitability Score
 * 
 * @param $argv[1] Destination file
 * @param $argv[2] Driver file
 * 
 * @return Echos out Driver/Destination combination, along with the Suitability Score of that combo
 */
require_once "src/classes/Assignment.php";

// if either the destination or driver file isn't passed, die
if(!isset($argv[1])){die("Please pass in a Destinations filename\n");}
if(!isset($argv[2])){die("Please pass in a Drivers filename\n");}

$assignment = new Assignment();
$assignment->setDestinationsFile($argv[1]);
$assignment->setDriversFile($argv[2]);

$finalAssignments = $assignment->assign();
foreach($finalAssignments as $driver => $v){
   echo "DRIVER: " . $driver . " -> " . $v['destination'] . " [Suitability Score: " .$v['suitabilityScore'] . "]\n";
}
?>