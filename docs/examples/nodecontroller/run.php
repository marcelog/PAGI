#!/usr/bin/env php
<?php
declare(ticks=1);

date_default_timezone_set('America/Buenos_Aires');
define('ROOT_PATH', realpath(__DIR__ . '/../../..'));
ini_set('include_path', implode(PATH_SEPARATOR, array(
    ROOT_PATH . '/src/mg', 
    ROOT_PATH . '/vendor/php/log4php',
    ini_get('include_path')
)));
require_once ROOT_PATH . '/src/mg/PAGI/Autoloader/Autoloader.php';
PAGI\Autoloader\Autoloader::register();

require_once __DIR__ . '/example.php';

use PAGI\Client\Impl\ClientImpl as PagiClient;

// Go, go, gooo!
$pagiClientOptions = array(
    'log4php.properties' => ROOT_PATH . '/resources/log4php.properties',
);
$pagiClient = PagiClient::getInstance($pagiClientOptions);
$pagiAppOptions = array(
    'pagiClient' => $pagiClient,
);
$pagiApp = new MyPagiApplication($pagiAppOptions);
pcntl_signal(SIGHUP, array($pagiApp, 'signalHandler'));
$pagiApp->init();
$pagiApp->run();
