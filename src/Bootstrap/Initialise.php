<?php

/*
Initial configuration for the PHP runtime
Such as global ini_set.. default timezone.. etc
 */
class Initialise{

	public function __construct(){

		date_default_timezone_set('Australia/Sydney');

	}

}