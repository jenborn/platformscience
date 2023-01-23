<?php

require_once "classes/Assignment.php";

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