<?php
require __DIR__ . implode(DIRECTORY_SEPARATOR, array(
    '',
    '..',
    '..',
    '..',
    'vendor',
    'autoload.php'
));

require __DIR__ . implode(DIRECTORY_SEPARATOR, array(
    implode(DIRECTORY_SEPARATOR, array(
        '',
        '..',
        'quickstart',
        'MyPAGIApplication.php'
    ))
));

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

$mock = new PAGI\Client\Impl\MockedClientImpl(array(
    'variables' => $variables
));
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
    ->onGetFullVariable(true, '6')
    ->onGetFullVariable(true, '1')
    ->onGetFullVariable(true, '2')
    ->onGetFullVariable(true, '3')
    ->onGetFullVariable(true, '4')
    ->onGetFullVariable(true, '5')
    ->onGetFullVariable(true, '6')
    ->onGetFullVariable(true, '1')
    ->onGetFullVariable(true, '2')
    ->onGetFullVariable(true, '3')
    ->onGetFullVariable(true, '4')
    ->onGetFullVariable(true, '5')
    ->onDial(true, 'name', 'number', '20', 'ANSWER', '#asd')
    ->onSayPhonetic(true, '2')
    ->onSayAlpha(true, '3')
    ->onSayTime(true, '4')
    ->onSayDateTime(true, '5')
    ->onSayDate(true, '6')
    ->onWaitDigit(true, '7')
    ->onWaitDigit(true, '7')
    ->onRecord(true, false, '#', 1000)
;
$app = new MyPAGIApplication(array('pagiClient' => $mock));
$app->init();
$app->run();
$app->shutdown();
