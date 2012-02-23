<?php

require_once 'PAGI/Autoloader/Autoloader.php';
PAGI\Autoloader\Autoloader::register();
$variables = array(
    'agi_request' => 'request.php',
    'agi_channel' => 'SIP/blah-00803890',
    'agi_language' => 'ar',
    'agi_type' => 'SIP',
    'agi_uniqueid' => '1330012581.77',
    'agi_version' => '1.6.0.9',
    'agi_callerid' => '40',
    'agi_calleridname' => 'Admin',
    'agi_callingpres' => '1',
    'agi_callingani2' => '0',
    'agi_callington' => '0',
    'agi_callingtns' => '0',
    'agi_dnid' => '55555555',
    'agi_rdnis' => 'unknown',
    'agi_context' => 'default',
    'agi_extension' => '55555555',
    'agi_priority' => '1',
    'agi_enhanced' => '0.0',
    'agi_accountcode' => '',
    'agi_threadid' => '1095317840'
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
//var_dump($mock->waitDigit(1000));
