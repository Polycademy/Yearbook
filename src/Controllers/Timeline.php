<?php

namespace Yearbook\Controllers;

use Yearbook\Controllers\AbstractController;

class Timeline extends AbstractController{

	public function __construct(Response $response){

		parent::construct($response);

	}

	public function get(){

		//determine whether to get one or get many depending on named parameters

	}

}