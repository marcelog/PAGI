<?php
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
use PAGI\Node\Node;

// Go, go, gooo!
$pagiClientOptions = array(
    'log4php.properties' => ROOT_PATH . '/resources/log4php.properties',
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
    ->assertSaySound('pp/30', 1)
    ->assertSayDigits(123, 1)
    ->assertSayNumber(321, 1)
    ->assertSayDateTime(1, 'dmY', 1)
    ->doBeforeValidInput(function (Node $node) {
        $client = $node->getClient();
        $client
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