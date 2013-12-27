<?php

namespace Yearbook\Bootstrap\Router;

class Router{

	protected $loader;

	public function __construct($loader){

		$loader->setMiddleware($this->globalMiddleware());
		$this->loader = $loader;
		$this->register(new Klien\Klien);

	}

	protected globalMiddleware(){

		//outer to inner
		return [
			'Yearbook\Middleware\Output'
		];

	}

	protected function register($router){

		//BIG PROBLEM WITH KLEIN: (simultaneous route matching)
		//respond to all! (but there's no terminate upon first match) SEE: https://github.com/chriso/klein.php/issues/156
		$router->respond($this->controller('Yearbook\Controllers\Home'));

		$router->dispatch();

	}

	protected function controller($controller, array $middleware = null){

		return function($request_parameters) use ($controller, $middleware){

			$this->loader->handleController($controller, $request_parameters, $middleware);

		};

	}

}
