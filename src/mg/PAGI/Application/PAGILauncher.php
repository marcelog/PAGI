<?php
require_once 'PAGI/Autoloader/Autoloader.php'; // Include ding autoloader.
Autoloader::register(); // Call autoloader register for ding autoloader.

try
{
    $appName = getenv('PAGIApplication');
    $bootstrap = getenv('PAGIBootstrap');
    $log4php = getenv('log4php_properties');
    include_once $bootstrap;
    $myApp = new $appName(
        array('log4php.properties' => realpath($log4php))
    );
    $myApp->init();
    $myApp->run();
} catch (\Exception $e) {
    var_dump($e);
    $myApp->log('Exception caught: ' . $e);
}
