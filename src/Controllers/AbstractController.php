<?php

namespace Yearbook\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Yearbook\Middleware\MiddlewareInterface;

abstract class AbstractController implements MiddlewareInterface{

	protected $request;
	protected $response;

	public function __construct(Response $response){

		$this->response = $response;
		
	}

	public function handle(Request $request){

		$this->request = $request;

		$method = strtolower($this->request->getMethod());
		if(is_callable(array($this, $method), true)){
			return $this->{$method}();
		}else{
			$this->response->setStatusCode(405);
			$this->response->setContent('Requested method is not available on this resource.');
			return $this->response;
		}

	}

	//can this be overwritten in the child object?
	protected function options(){

		//this method should instinctvely return a list of methods available for use

	}

}