<?php
date_default_timezone_set('America/Buenos_Aires');
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
use PAGI\Node\Node;

// Go, go, gooo!
$pagiClientOptions = array();
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