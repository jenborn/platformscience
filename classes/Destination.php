<?php

class Destination {
      public $address;
      public $streetName;
      public $streetNameLength;
      
      public function __construct($input){
         $this->address = $input;
      }

      /**
      *	We want to keep the address intact in $this->address
      * but we need to extract the street name
      * so we use preg_match to remove the left-side digits
      * then remove everything after the comma, before the city, state zip
      * and remove whitespace at both ends
      */
      public function getStreetName(){
         if(preg_match('/([^\d]+)\s?(.+)/i', $this->address, $result)){
	         $this->streetName = trim(strstr($result[0], ",", true));
	      }
      }

      public function getStreetNameLength(){
         $this->streetNameLength = strlen($this->streetName);
      }
}