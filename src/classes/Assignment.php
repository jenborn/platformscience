<?php

require_once "Driver.php";
require_once "Destination.php";
require 'vendor/autoload.php';
/**
 * Handle the assignment of drivers to destinations according to Suitability Score
 * 
 * 0.0.1
 */
class Assignment
{
	public $driversFile;
	protected $drivers;
	public $destinationsFile;
	protected $destinations;
	protected $assignments = [];
	protected $driverData;
	protected $driverFinalScore;
	protected $highestScores = [];

	public function setDriversFile(string $file)
	{
		$this->driversFile = $file;
	}

	public function setDestinationsFile(string $file)
	{
		$this->destinationsFile = $file;
	}

	public function assign(): array
	{
		$this->loadDrivers();
		$this->loadDestinations();

		$assignments = $this->process();
		return $assignments;
	}

	private function loadDrivers()
	{
		$this->drivers = $this->importCSV($this->driversFile);
	}

	private function loadDestinations()
	{
		$this->destinations = $this->importCSV($this->destinationsFile);
	}

	/**
	 * Import a csv file and return the contents in an array
	 * 
	 * @param string $file
	 * 
	 * @return array $return The contents of the imported file
	 */
	public function importCSV(string $file): array
	{
		$return = [];
		$file = fopen($file, 'r');

		while (($line = fgetcsv($file)) !== FALSE) {
			// pushing the different values a little differently
			// because of the way it breaks up the data (by commas)
			// also, we don't need the drivers array to be the below for every driver:
			// [0] => John Doe
			if (isset($line[1])) {
				array_push($return, implode(",", $line));
			} else {
				array_push($return, $line[0]);
			}
		}
		fclose($file);
		return $return;
	}

	/**
	 * Process both the driver and destination data
	 * 
	 * @return array $this->assignments Assignments
	 */
	private function process(): array
	{
		$allDriverData = [];

		foreach ($this->drivers as $v) {
			$driver = new Driver($v);
			$driver->processName();
			$driverData = $driver->setScore();
			// not using array_push here because I don't want the
			// array to be nested with a numeric key on the outside
			// i want to use the driver's name as the key
			// it will only loop 1x
			foreach ($driverData as $key => $value) {
				$allDriverData[$key] = $value;
			}
		}
		//print_r($allDriverData);
		//echo "\n\n";
		$scoreArray = [];

		foreach ($this->destinations as $d) {
			$destination = new Destination($d);
			$destination->getStreetName();
			$destination->getStreetNameLength();

			foreach ($allDriverData as $dK => $dV) {
				if ($destination->streetNameLength % 2 == 0) { // even
					// ss is vowelScore
					$base = $dV['vowelScore'];
				} else { // odd
					// ss is consonantScore
					$base = $dV['consonantScore'];
				}

				// now check for common factors in length
				if ($this->hasCommonFactors($destination->streetNameLength, $dV['nameLength'])) {
					$finalScore = $base + (.5 * $base);
				} else {
					$finalScore = $base;
				}

				if (!in_array($finalScore, $this->highestScores)) {
					array_push($this->highestScores, $finalScore);
				}

				if (isset($scoreArray["$finalScore"]) && isset($scoreArray["$finalScore"][$dK])) {
					array_push($scoreArray["$finalScore"][$dK], $d);
				} else {
					$scoreArray["$finalScore"][$dK][0] = $d;
				}
			}
		}

		// since we're going to use $this->highestScores to make sure we're using the highest,
		// sort desc
		rsort($this->highestScores);
/* 		echo "HIGHEST SCORES:\n";
		print_r($this->highestScores);
		echo "\n\n"; */

/* 		echo "SCORE ARRAY:\n";
		print_r($scoreArray);
		echo "\n\n"; */

		$this->sortByHighScore($scoreArray);

		return $this->assignments;
	}

	private function sortByHighScore(array $scoreArray): void
	{
		// since score is the most important
		// we're prioritizing that via $this->highestScores
		// and searching $scoreArray, first by Driver, then by Destination to ensure no duplicates
		for ($q = 0; $q < count($this->highestScores); $q++) {
			$thisScore = $this->highestScores[$q];

			foreach ($scoreArray["$thisScore"] as $thisDriver => $dest) {
				// make sure this driver isn't already assigned

				if (!isset($this->assignments[$thisDriver])) {
					foreach ($dest as $destVal) {
						// make sure this destination isn't already assigned
						$exists = array_search($destVal, array_column($this->assignments, 'destination'));

						if ($exists === false) {
							$this->assignments[$thisDriver] = ['destination' => $destVal, 'suitabilityScore' => $thisScore];
							break;  // once we've assigned the driver, we can move on to the next driver -- no need to loop through the rest of this one's destinations
						}
					}
				}
			}
		}
	}

	/**
	 * Determine if the 2 values have common factors other than 1
	 * 
	 * @param int $a StreetNameLength
	 * @param int $b DriverNameLength
	 * 
	 * modified https://stackoverflow.com/questions/41936532/how-to-find-the-common-divisors-of-two-numbers-in-php
	 */
	public function hasCommonFactors(int $a, int $b): bool
	{
		$min = ($a < $b) ? $a : $b;

		for ($i = 2; $i < $min; $i++) {
			if (($a % $i == 0) && ($b % $i == 0)) {
				return true;
			}
		}

		return false;
	}
}
