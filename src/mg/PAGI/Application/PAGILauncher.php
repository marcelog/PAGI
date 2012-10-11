<?php
/**
 * This is our "dispatcher", you should invoke this one from your dialplan.
 * This script will assume the existance of the following environment variables:
 * -- PAGIApplication: Name of the class that extends PAGIApplication that you
 * want to run.
 * -- PAGIBootstrap: Name of the file (like a.php) that you want to include_once
 * before running the application.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Application
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/PAGI/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
require_once 'PAGI/Autoloader/Autoloader.php'; // Include PAGI autoloader.
\PAGI\Autoloader\Autoloader::register(); // Call autoloader register for PAGI autoloader.
use PAGI\Application\Exception\InvalidApplicationException;
use PAGI\Application\PAGIApplication;

$appName = getenv('PAGIApplication');
$bootstrap = getenv('PAGIBootstrap');
$myApp = '';
$logger = null;

/*
 * Example: set up Monolog
 *
 * $logger = new \Monolog\Logger('pagilogger');
 * $logger->pushHandler(new \Monolog\Handler\StreamHandler('/path/to/your.log', \Monolog\Logger::WARNING));
 */

try
{

    include_once $bootstrap;
    if (!class_exists($appName, true)) {
        throw new \Exception($appName . ' is not loaded');
    }
    $rClass = new ReflectionClass($appName);
    if (!$rClass->isSubclassOf('PAGI\\Application\\PAGIApplication')) {
        throw new \Exception($appName . ': Invalid application');
    }
    $agi = PAGI\Client\Impl\ClientImpl::getInstance(array('logger' => $logger));
    $myApp = new $appName(array('pagiClient' => $agi));
    $myApp->init();
    $myApp->run();
} catch (\Exception $e) {
    $myApp->log($e);
}
