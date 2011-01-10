<?php
require_once 'PAGI/Autoloader/Autoloader.php'; // Include ding autoloader.
Autoloader::register(); // Call autoloader register for ding autoloader.
use PAGI\Application\Exception\InvalidApplicationException;

try
{
    $appName = getenv('PAGIApplication');
    $bootstrap = getenv('PAGIBootstrap');
    $log4php = getenv('log4php_properties');
    include_once $bootstrap;
    $neededMethods = array(
    	'init', 'run', 'shutdown', 'errorHandler', 'signalHandler'
  	);
    if (!class_exists($appName, true)) {
        throw new InvalidApplicationException($appName . ' is not loaded.');
    }
    foreach ($neededMethods as $method) {
        if (!method_exists($appName, $method)) {
            throw new InvalidApplicationException($appName . ': Missing ' . $method);
        }
    }
    $myApp = new $appName(
        array('log4php.properties' => realpath($log4php))
    );
    $myApp->init();
    $myApp->run();
} catch (\Exception $e) {
    var_dump($e);
    $myApp->log('Exception caught: ' . $e);
}
