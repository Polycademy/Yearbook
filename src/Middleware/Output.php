<?php

namespace Yearbook\Middleware;

use Yearbook\Middleware\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;

class Output implements MiddlewareInterface{

	protected $middleware;

	public function __construct(MiddlewareInterface $middleware){

		$this->middleware = $middleware;
	
	}

	public function handle(Request $request){

		$response = $this->middleware->handle($request);

		//$request is passed by reference
		$response->prepare($request);
		$response->send();

		return $response;

	}

}