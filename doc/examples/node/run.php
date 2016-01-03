#!/usr/bin/env php
<?php
declare(ticks=1);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require __DIR__ . implode(DIRECTORY_SEPARATOR, array(
    '',
    '..',
    '..',
    '..',
    'vendor',
    'autoload.php'
));

require_once __DIR__ . '/example.php';

use PAGI\Client\Impl\ClientImpl as PagiClient;

// Go, go, gooo!
$pagiClientOptions = array();
$pagiClient = PagiClient::getInstance($pagiClientOptions);
$pagiAppOptions = array(
    'pagiClient' => $pagiClient,
);
$pagiApp = new MyPagiApplication($pagiAppOptions);
pcntl_signal(SIGHUP, array($pagiApp, 'signalHandler'));
$pagiApp->init();
$pagiApp->run();
