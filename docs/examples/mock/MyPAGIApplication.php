<?php
require_once 'PAGI/Autoloader/Autoloader.php';
PAGI\Autoloader\Autoloader::register();
require_once __DIR__ . '/../quickstart/MyPAGIApplication.php';

$variables = array(
    'request' => 'request.php',
    'channel' => 'SIP/blah-00803890',
    'language' => 'ar',
    'type' => 'SIP',
    'uniqueid' => '1330012581.77',
    'version' => '1.6.0.9',
    'callerid' => '40',
    'calleridname' => 'Admin',
    'callingpres' => '1',
    'callingani2' => '0',
    'callington' => '0',
    'callingtns' => '0',
    'dnid' => '55555555',
    'rdnis' => 'unknown',
    'context' => 'default',
    'extension' => '55555555',
    'priority' => '1',
    'enhanced' => '0.0',
    'accountcode' => '',
    'threadid' => '1095317840'
);

$mock = new PAGI\Client\Impl\MockedClientImpl($variables);
$mock
    ->assert('sayDigits', array('12345', '12#'))
    ->assert('sayNumber', array('12345', '12#'))
    ->onSayDigits(true, '1')
    ->onSayNumber(true, '2')
    ->onGetData(false)
    ->onGetOption(true, '4')
    ->onStreamFile(true, '#')
    ->onChannelStatus(PAGI\Client\ChannelStatus::LINE_UP)
    ->onChannelStatus(PAGI\Client\ChannelStatus::LINE_BUSY)
    ->onGetVariable(true, 123)
    ->onGetFullVariable(true, 456)
    ->onGetFullVariable(true, 789)
    ->onGetFullVariable(true, 'asd')
    ->onGetFullVariable(true, '1')
    ->onGetFullVariable(true, '2')
    ->onGetFullVariable(true, '3')
    ->onGetFullVariable(true, '4')
    ->onGetFullVariable(true, '5')
    ->onGetFullVariable(true, '1')
    ->onGetFullVariable(true, '2')
    ->onGetFullVariable(true, '3')
    ->onGetFullVariable(true, '4')
    ->onGetFullVariable(true, '5')
    ->onGetFullVariable(true, '1')
    ->onGetFullVariable(true, '2')
    ->onGetFullVariable(true, '3')
    ->onGetFullVariable(true, '4')
    ->onGetFullVariable(true, '5')
    ->onGetFullVariable(true, '5')
    ->onDial(true, 'name', 'number', '20', 'ANSWER', '#asd')
    ->onSayPhonetic(true, '2')
    ->onSayAlpha(true, '2')
    ->onSayTime(true, '2')
    ->onSayDateTime(true, '2')
    ->onSayDate(true, '2')
    ->onWaitDigit(true, '2')
    ->onRecord(true, false, '#', 1000)
;
$app = new MyPAGIApplication(array('pagiClient' => $mock));
$app->init();
$app->run();
$app->shutdown();
