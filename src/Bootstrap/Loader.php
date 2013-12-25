<?php

//the bootstrap will load the pimple IOC
//Which will bring in all the configuration, and all of the controllers, modules, libraries
//Bootstrap can also bring in any secrets..?
//Since the configuration will be stored inside Pimple's IOC array, this can then be inserted into any controllers that require it

$loader = new Pimple;

$loader['Logger'] = $loader->share(function($c){
	//get the logger object with the Monolog
});

//it becomes possible to do this: throw $error() no longer throw new Exception or it could be possible to do like Modules\Error::create()
$loader['Error'] = function($message = null, $code = 0, $previous = null) use ($loader){
	return new Modules\Error($message, $code, $previous, $loader['logger']);
};

$loader['Config'] = $loader->share(function($c){
	//get the config object loading all the necessary configuration from $_ENV...
});

$loader['Database'] = $loader->share(function($c){
	$dbh = new PDO('mysql:host=localhost;dbname=yearbook', 'root', '', array(
		PDO::ATTR_PERSISTENT	=> true
	));
	return $dbh;
});

$loader['Storage'] = $loader->share(function($c){
	$storage = new Storage\MySQLAdapter($c['Database']);
	return $storage;
});

$loader['Models/Timeline'] = $loader->share(function($c){
	$timeline_model = new Modules\TimelineModel($c['Storage']);
	return $timeline_model;
});