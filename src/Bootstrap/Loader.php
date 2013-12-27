<?php

namespace Yearbook\Bootstrap;

class Loader{

	protected $loader;
	protected $middleware = [];

	public function __construct(){

		$this->loader = new Auryn\Provider(new Auryn\ReflectionPool);
		$this->register();

	}

	public function __call($method, $args){

		return call_user_func_array(array($this->loader, $method), $args);

	}

	public function setMiddleware(array $middleware){

		$this->middleware = $middleware;

	}

	public function handleController($controller, $request_parameters, array $middleware = null){

		$controller = $this->loader->make($controller);
		$request = $this->loader->make('Symfony\Component\HttpFoundation\Request');
		$builder = $this->loader->make('Yearbook\Middleware\MiddlewareBuilder');

		//add the request_parameters to the attributes object of the $request instance
		//the request parameters will store the URL's stored named parameters from the Router


		//need to use the StackBuilder (something similar) to build the middleware stack with the controller
		//as the final middleware
		$middleware = ($middleware) ? $middleware : $this->middleware;
		foreach($middleware as $handler){
			$builder->push($handler);
		}
		$builder->resolve($request, $controller);

		//You cannot push a fully instantiated middleware into the builder, since it needs to be constructed
		//as an onion
		//So the Loader itself needs to also act as the MiddlewareBuilder

	}

	protected function register(){

		//CONFIGURATION

		//ERROR needs to be able to be passed in as a parameter to classes that need the error object as $error();
		$error = function($message, $code, $previous){
			return new Yearbook\Modules\Error($message, $code, $previous, $this->loader->make('Monolog\Logger'));
		};

		//LOGGER
		$loggerFactory = function(){
			$logger = new Monolog\Logger('Yearbook');
			$logger->pushHandler(new Monolog\StreamHandler(__DIR__ . '/../../logs/yearbook.log', Monolog\Logger::NOTICE));
			$logger->pushHandler(new Monolog\FirePHPHandler());
			return $logger;
		};
		$this->loader->share('Monolog\Logger');
		$this->loader->delegate('Monolog\Logger', $loggerFactory);

		//ROUTER
		$this->loader->share('Klein\Klein');

		//REQUEST
		$requestFactory = function(){
			$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
			//php-fpm doesn't support getallheaders yet: https://bugs.php.net/bug.php?id=62596
			//however apache and fast-cgi does support getallheaders
			if(function_exists('getallheaders')){
				$headers = getallheaders();
				if(isset($headers['Authorization'])){
					$request->headers->set('Authorization', $headers['Authorization']);
				}
			}
			return $request;
		};
		$this->loader->share('Symfony\Component\HttpFoundation\Request');
		$this->loader->delegate('Symfony\Component\HttpFoundation\Request', $requestFactory);

		//PDO
		$this->loader->share('PDO');
		$this->loader->define('PDO', [
			':dsn'	=> 'mysql:host=localhost;dbname=yearbook',
			':username'	=> 'root',
			':password'	=> '',
			':driver_options'	=> [
				\PDO::ATTR_PERSISTENT	=> true
			]
		]);

		$this->loader->share('Yearbook\Storage\MySQLAdapter');

		$this->loader->share('Yearbook\Modules\TimelineModel');

	}

}