<?php
/**
 * This is our "dispatcher", you should invoke this one from your dialplan.
 * This script will assume the existance of the following environment variables:
 * -- PAGIApplication: Name of the class that extends PAGIApplication that you
 * want to run.
 * -- PAGIBootstrap: Name of the file (like a.php) that you want to include_once
 * before running the application.
 * -- log4php: Absolute full path to the log4php.properties (may be a dummy
 * path, in this case you may gain some performance but wont be able to see
 * any logs apart from the asterisk console).
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Application
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
require_once 'PAGI/Autoloader/PAGI_Autoloader.php'; // Include ding autoloader.
PAGI_Autoloader::register(); // Call autoloader register for ding autoloader.
use PAGI\Application\Exception\InvalidApplicationException;

$appName = getenv('PAGIApplication');
$bootstrap = getenv('PAGIBootstrap');
$log4php = realpath(getenv('log4php_properties'));
$myApp = '';
//\Logger::configure($log4php);
//$logger = \Logger::getLogger('PAGI.Launcher');
$neededMethods = array(
	'init', 'run', 'shutdown', 'errorHandler', 'signalHandler'
);
try
{

    include_once $bootstrap;
    if (!class_exists($appName, true)) {
        throw new InvalidApplicationException($appName . ' is not loaded.');
    }
    foreach ($neededMethods as $method) {
        if (!method_exists($appName, $method)) {
            throw new InvalidApplicationException($appName . ': Missing ' . $method);
        }
    }
    $myApp = new $appName(array('log4php.properties' => $log4php));
    $myApp->init();
    $myApp->run();
} catch (\Exception $e) {
    $myApp->log($e);
}
