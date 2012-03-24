<?php
ini_set('include_path', implode(PATH_SEPARATOR, array(
    __DIR__ . '/../../../src/mg', ini_get('include_path')
)));
require_once __DIR__ . '/../../../src/mg/PAGI/Autoloader/Autoloader.php';
PAGI\Autoloader\Autoloader::register();

require_once __DIR__ . '/example.php';

use PAGI\Client\Impl\ClientImpl as PagiClient;
use PAGI\Node\Node;

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
    ->runWithInput('1')
    ->doBeforeValidInput(function (Node $node) {
        $client = $node->getClient();
        $client
            ->onPlayBusyTone(true)
            ->onStreamFile('hi')
            ->assert('streamFile', array('hi'))
            ->assert('playBusyTone')
        ;
    })
    ->doBeforeFailedInput(function (Node $node) {
    })
;
$pagiApp->init();
$pagiApp->run();