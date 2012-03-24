<?php
ini_set('include_path', implode(PATH_SEPARATOR, array(
    __DIR__ . '/../../../src/mg', ini_get('include_path')
)));
require_once __DIR__ . '/../../../src/mg/PAGI/Autoloader/Autoloader.php';
PAGI\Autoloader\Autoloader::register();

require_once __DIR__ . '/example.php';

use PAGI\Client\Impl\ClientImpl as PagiClient;

// Go, go, gooo!
$pagiClientOptions = array(
    'log4php.properties' => __DIR__ . '/log4php.properties',
);
$pagiClient = new \PAGI\Client\Impl\MockedClientImpl($pagiClientOptions);
$pagiAppOptions = array(
    'pagiClient' => $pagiClient,
);
$pagiApp = new MyPagiApplication($pagiAppOptions);
pcntl_signal(SIGHUP, array($pagiApp, 'signalHandler'));

$pagiClient
    ->onAnswer(true)
    ->onCreateNode('mainMenu')
    ->runWithInput('888')
    ->assertSaySound('pp/50', 2)
    ->assertMaxInputAttemptsReached()
;
$pagiApp->init();
$pagiApp->run();