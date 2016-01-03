<?php
require __DIR__ . implode(DIRECTORY_SEPARATOR, array(
    '',
    '..',
    '..',
    '..',
    'vendor',
    'autoload.php'
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

$mock = new PAGI\Client\Impl\MockedClientImpl();
$mock
    ->assert('waitDigit', array(1000))
    ->assert('streamFile', array('blah', '01234567890*#'))
    ->assert('dial', array('SIP/blah', array(60, 'tH')))
    ->assert('getData', array('blah', 123, '#'))
    ->assert('sayDateTime', array('asd', 123))
    ->assert('setVariable', array('asd', 'asd'))
    ->onAnswer(true)
    ->onWaitDigit(false)
    ->onWaitDigit(true, '*')
    ->onStreamFile(false)
    ->onStreamFile(true, '#')
    ->onGetData(false)
    ->onGetData(true, '44449*#')
    ->onSayDate(true, '#')
    ->onSayTime(true, '#')
    ->onSayDateTime(true, '#')
    ->onSayAlpha(true, '#')
    ->onSayPhonetic(true, '#')
    ->onSayNumber(true, '#')
    ->onSayDigits(true, '#')
    ->onDial(true, 'name', '01151992266', 20, 'ANSWER', '#blah')
    ->onHangup(true)
;
var_dump($mock->answer());
var_dump($mock->setVariable('asd', 'asd'));
var_dump($mock->waitDigit(1000));
var_dump($mock->waitDigit(1000));
var_dump($mock->streamFile('blah', '01234567890*#'));
var_dump($mock->streamFile('blah', '01234567890*#'));
var_dump($mock->getData('blah', 123, '#'));
var_dump($mock->getData('blah', 123, '#'));
var_dump($mock->sayDate('asd', time()));
var_dump($mock->sayTime('asd', time()));
var_dump($mock->sayDateTime('asd', 123));
var_dump($mock->sayAlpha('asd'));
var_dump($mock->sayPhonetic('asd'));
var_dump($mock->sayNumber(123));
var_dump($mock->sayDigits(123));
var_dump($mock->dial('SIP/blah', array(60, 'tH')));
var_dump($mock->hangup());
