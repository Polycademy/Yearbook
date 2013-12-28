<?php

namespace Yearbook\Modules;

use Monolog\Logger as Monolog;

//logger can use different loggers for different severities, so it can escalate the alerts
class Logger{

	public function __construct(Monolog $logger){

		$logger->pushHandler(new Monolog\StreamHandler(__DIR__ . '/../../logs/yearbook.log', Monolog\Logger::NOTICE));
		$logger->pushHandler(new Monolog\FirePHPHandler());
		return $logger;

	}

}