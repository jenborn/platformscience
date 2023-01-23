<?php

class Driver {

   public $driverName;
   public $vowels;
   public $consonants;
   public $driverData;

   public function __construct($input){
         $this->driverName = $input;
   }

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

   public function setScore(){
      $this->driverData = [$this->driverName => ['nameLength' => strlen($this->driverName), 'numVowels' => $this->vowels, 'numConsonants' => $this->consonants, 'vowelScore' => $this->vowels * 1.5, 'consonantScore' => $this->consonants]];
      return $this->driverData;
   }
}