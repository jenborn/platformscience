<?php
/**
 * Basic functions for drivers
 * 
 * This class processes the driver's name and sets the base suitability scores for the driver
 * 
 * 0.0.1
 */
class Driver {

   public $driverName;
   public $vowels;
   public $consonants;
   public $driverData;

   public function __construct($input){
         $this->driverName = $input;
   }

    /**
     * Set the vowels/consonants for a driver's name 
     * Process the letters of the driver's name individually, checking to see if they're in the vowel array
     * and iterating those properties appropriately to keep track
     */
   public function processName(){
      $vowels = ['a', 'e', 'i', 'o', 'u'];

	   foreach(str_split($this->driverName) as $letter){
	      if($letter == " "){continue;}

         if(in_array($letter, $vowels)){
            $this->vowels++;
         }else{
            $this->consonants++;
         }
	   }
   }

   /**
    * Load the driverData property with everything we need to later make all our decisions
    * vowelScore = number of vowels * 1.5
    * consonantScore = number of consonants
    */
   public function setScore(){
      $this->driverData = [$this->driverName => 
         ['nameLength' => strlen($this->driverName), 
         'numVowels' => $this->vowels, 
         'numConsonants' => $this->consonants, 
         'vowelScore' => $this->vowels * 1.5, 
         'consonantScore' => $this->consonants]];
      return $this->driverData;
   }
}