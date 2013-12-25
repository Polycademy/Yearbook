<?php

namespace Modules;

use Exception;
use Modules\Logger;

//Exception: http://php.net/manual/en/language.exceptions.extending.php
//use http://tools.ietf.org/html/rfc5424 as error codes!

class Error extends Exception{


	//this is pure error object
	//this represents a number of things
	//it will be used as an exception object
	//an exception object in Dragoon means several things:
	//1. Public error message(s) to be shown to the user it can be array form, object form or string form
	//2. Diagnostic error object that is logged, rather than shown
	//3. Internationalisation of the error messages
	//Errors can be thrown from anywhere, from controllers to modules to models to libraries
	//the main point is to capture the this error message, and show the public errors, but log the diagnostic errors
	//after going through i8n.
	//This is where a logging module would be good. A logging module could be called in from Advisors (which can log standard access).
	//A logging module can be called in from the Error object, that as soon as it is constructed, any diagnostic
	//exceptions will be passed. Now this depends on the type of error object
	//Consider if a model tried to retrieve some data and couldn't find it. If this data is meant to always exist
	//this is a real exception, and should have diagnostic information logged. However if this data might not have existed such as a blog post that was deleted, then this should not have diagnostic information.

	public function __construct($diagnostic = null, $code = 0, Exception $previous = null){

		//always accept array, always return array...

		if(is_string($diagnostic) OR is_numeric($diagnostic)){
			$diagnostic = (string) $diagnostic;
		}elseif(is_array($diagnostic)){
			
		}


		//accept an array
		//array(
		//	'diagnostic message' => 'blah',
		//	'public_message'
		//)

		parent::__construct($message, $code, $previous);

		//we can use the logger can call the logger as soon as this is intantiated... which is a bit weird because
		//it should be done when thrown, not necessarily
		//
		//ACTUALLY:
		//I think the logging should happen when an error object is CAUGHT.
		//That's when the error object is HANDLED.
		//It should not log every single time an object is created.

	}

	//we need to accept a Logger object into Error, but how to 
	//
	//
	//if the bootstrapper doe
	//throw new Exception();
	//throw $error

	public function setMessage($message){

		$this->message = $message;
	
	}

	//these static functions should create exceptions with the correct codes!
	public static function debug($message){

	}

	public static function info($message){

	}

	public static function notice($message){

	}

	public static function warning($message){

	}

	//5.3.3 requirement!
	public static function error($message){

	}

	public static function critical($message){

	}

	public static function alert($message){

	}

	public static function emergency($message){

	}

}