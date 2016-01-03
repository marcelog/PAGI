<?php
/**
 * This class will test the agi client
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Client
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
use Psr\Log\NullLogger;

namespace {
    $mockFopen = false;
    $mockFwrite = false;
    $mockFwriteReturn = false;
    $mockTime = false;
    $mockFgets = false;
    $mockFgetsCount = 0;
    $mockTimeCount = 0;
    $mockTimeResult = 0;
    $mockFclose = false;
    $mockFreadReturn = false;
    $errorAGIRead = array(
		'agi_request:anagi.php',
		'agi_channel:SIP/jondoe-7026f150',
        false
    );
    $standardAGIStart = array(
        'agi_arg_1:arg1',
    	'agi_arg_2:arg2',
		'agi_request:anagi.php',
		'agi_channel:SIP/jondoe-7026f150',
		'agi_language:ar',
		'agi_type:SIP',
		'agi_uniqueid:1306865753.2488',
		'agi_version:1.6.0.9',
		'agi_callerid:666',
		'agi_calleridname:JonDoe',
		'agi_callingpres:1',
		'agi_callingani2:0',
		'agi_callington:0',
		'agi_callingtns:0',
		'agi_dnid:66666666',
		'agi_rdnis:unknown',
		'agi_context:netlabs',
		'agi_extension:55555555',
		'agi_priority:1',
		'agi_enhanced:0.0',
		'agi_accountcode:123',
		'agi_threadid:1105672528',
        ''
    );

    function setFgetsMock(array $readValues, $writeValues)
    {
        global $mockFgets;
        global $mockFopen;
        global $mockFgetsCount;
        global $mockFgetsReturn;
        global $mockFwrite;
        global $mockFwriteCount;
        global $mockFwriteReturn;
        $mockFgets = true;
        $mockFopen = true;
        $mockFwrite = true;
        $mockFgetsCount = 0;
        $mockFgetsReturn = $readValues;
        $mockFwriteCount = 0;
        $mockFwriteReturn = $writeValues;
    }
}

namespace PAGI\Client {
    function time() {
        global $mockTime;
        global $mockTimeCount;
        global $mockTimeReturn;
        if (isset($mockTime) && $mockTime === true) {
            if (!isset($mockTimeReturn[$mockTimeCount])) {
                return call_user_func_array('\time', func_get_args());
            }
            $result = $mockTimeReturn[$mockTimeCount];
            $mockTimeCount++;
            return $result;
        } else {
            return call_user_func_array('\time', func_get_args());
        }
    }
}
namespace PAGI\Client\Impl {
    function fclose() {
        global $mockFclose;
        if (isset($mockFclose) && $mockFclose === true) {
            return true;
        } else {
            return call_user_func_array('\fclose', func_get_args());
        }
    }
    function fopen() {
        global $mockFopen;
        if (isset($mockFopen) && $mockFopen === true) {
            return true;
        } else {
            return call_user_func_array('\fopen', func_get_args());
        }
    }
    function fwrite() {
        global $mockFwrite;
        global $mockFwriteCount;
        global $mockFwriteReturn;
        if (isset($mockFwrite) && $mockFwrite === true) {
            $args = func_get_args();
            if (isset($mockFwriteReturn[$mockFwriteCount]) && $mockFwriteReturn[$mockFwriteCount] !== false) {
                if ($mockFwriteReturn[$mockFwriteCount] === 'fwrite error') {
                    $mockFwriteCount++;
                    return 0;
                }
                $str = $mockFwriteReturn[$mockFwriteCount] . "\n";
                if ($str !== $args[1]) {
                    throw new \Exception(
                    	'Mocked: ' . print_r($mockFwriteReturn[$mockFwriteCount], true) . ' is '
                    	. ' different from: ' . print_r($args[1], true)
                    );
                }
            }
            $mockFwriteCount++;
            return strlen($args[1]);
        } else {
            return call_user_func_array('\fwrite', func_get_args());
        }
    }
    function fgets() {
        global $mockFgets;
        global $mockFgetsCount;
        global $mockFgetsReturn;
        if (isset($mockFgets) && $mockFgets === true) {
            $result = $mockFgetsReturn[$mockFgetsCount];
            $mockFgetsCount++;
            return is_string($result) ? $result . "\n" : $result;
        } else {
            return call_user_func_array('\fgets', func_get_args());
        }
    }
/**
 * This class will test the agi client
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Client
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_Client extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function can_set_logger()
    {
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $client->setLogger(new NullLogger);
        $this->assertTrue(true);
    }

    /**
     * @test
     * @expectedException \PAGI\Exception\PAGIException
     */
    public function cannot_read()
    {
        global $errorAGIRead;
        setFgetsMock($errorAGIRead, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
    }

    /**
     * @test
     */
    public function can_send()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'ANSWER'
        );
        $read = array(
            '200 result=result data',
        );
        setFgetsMock($read, $write);
        $refObject = new \ReflectionObject($client);
        $refMethod = $refObject->getMethod('send');
        $refMethod->setAccessible(true);
        $result = $refMethod->invoke($client, 'ANSWER');
        $this->assertEquals($result->getCode(), '200');
        $this->assertEquals($result->getResult(), 'result');
        $this->assertTrue($result->hasData());
        $this->assertEquals($result->getOriginalLine(), '200 result=result data');
        $this->assertEquals($result->getData(), 'data');
    }

    /**
     * @test
     */
    public function can_answer()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'ANSWER'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->answer();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function can_use_custom_stream()
    {
        $in = fopen(__DIR__ . '/../resources/inputstream.txt', 'r');
        $out = fopen(TMPDIR . '/output.txt', 'w+');
        $client = \PAGI\Client\Impl\ClientImpl::getInstance(array(
            'stdin' => $in,
        	'stdout' => $out
        ));
        $client->answer();
        fclose($in);
        fclose($out);
    }

    /**
     * @test
     */
    public function can_close()
    {
        global $standardAGIStart;
        global $mockFclose;
        $mockFclose = true;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $refClass = new \ReflectionClass('\PAGI\Client\Impl\ClientImpl');
        $refMethod = $refClass->getMethod('close');
        $refMethod->setAccessible(true);
        $refMethod->invoke($client);
    }

    /**
     * @test
     */
    public function can_hangup()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'HANGUP',
        	'HANGUP "somechannel"'
	    );
        $read = array(
            '200 result=1',
        	'200 result=1',
        );
        setFgetsMock($read, $write);
        $client->hangup();
        $client->hangup('somechannel');
    }

    /**
     * @test
     * @expectedException \PAGI\Exception\ChannelDownException
     */
    public function can_detect_fastagi_hangup()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'STREAM FILE "file" "#"'
        );
        $read = array(
            'HANGUP'
        );
        setFgetsMock($read, $write);
        $result = $client->streamFile('file', '#');
    }

    /**
     * @test
     * @expectedException \PAGI\Exception\ChannelDownException
     */
    public function cannot_answer()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'ANSWER'
        );
        $read = array(
            '200 result=-1',
        );
        setFgetsMock($read, $write);
        $client->answer();
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\ChannelDownException
     */
    public function cannot_hangup()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'HANGUP'
        );
        $read = array(
            '200 result=-1',
        );
        setFgetsMock($read, $write);
        $client->hangup();
    }
    /**
     * @test
     */
    public function can_set_context()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SET CONTEXT "context"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->setContext('context');
    }
    /**
     * @test
     */
    public function can_set_extension()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SET EXTENSION "1313"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->setExtension('1313');
    }
    /**
     * @test
     */
    public function can_set_priority()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SET PRIORITY "3"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->setPriority('3');
    }
    /**
     * @test
     */
    public function can_set_autohangup()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SET AUTOHANGUP 3'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->setAutoHangup('3');
    }
    /**
     * @test
     */
    public function can_set_callerid()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $callerIdW = array(
        	'SET CALLERID "\"name\"<123>"'
        );
        $callerIdR = array(
            '200 result=1',
        );
        setFgetsMock($callerIdR, $callerIdW);
        $client->setCallerId('name', 123);
    }
    /**
     * @test
     */
    public function can_send_image()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SEND IMAGE "file"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->sendImage('file');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\PAGIException
     */
    public function cannot_send_image()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SEND IMAGE "file"'
        );
        $read = array(
            '200 result=-1',
        );
        setFgetsMock($read, $write);
        $client->sendImage('file');
    }
    /**
     * @test
     */
    public function can_send_text()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SEND TEXT "text"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->sendText('text');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\PAGIException
     */
    public function cannot_send_text()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SEND TEXT "text"'
        );
        $read = array(
            '200 result=-1',
        );
        setFgetsMock($read, $write);
        $client->sendText('text');
    }
    /**
     * @test
     */
    public function can_database_put()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE PUT "family" "key" "value"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->databasePut('family', 'key', 'value');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function cannot_database_put()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE PUT "family" "key" "value"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $client->databasePut('family', 'key', 'value');
    }
    /**
     * @test
     */
    public function can_database_deltree()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE DELTREE "family" "key"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->databaseDeltree('family', 'key');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function cannot_database_deltree()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE DELTREE "family" "key"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $client->databaseDeltree('family', 'key');
    }
    /**
     * @test
     */
    public function can_database_del()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE DELTREE "family" "key"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->databaseDel('family', 'key');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function cannot_database_del()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE DELTREE "family" "key"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $client->databaseDel('family', 'key');
    }
    /**
     * @test
     */
    public function can_database_get()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE GET "family" "key"'
        );
        $read = array(
            '200 result=1 (something)',
        );
        setFgetsMock($read, $write);
        $this->assertEquals($client->databaseGet('family', 'key'), 'something');
    }
    /**
     * @test
     */
    public function can_console_log()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'VERBOSE "line1" 1',
        	'VERBOSE "line2" 1'
        );
        $read = array(
            '200 result=1',
            '200 result=1'
        );
        setFgetsMock($read, $write);
        $client->consoleLog("line1\r\nline2\r\n");
    }

    /**
     * @test
     * @expectedException \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function cannot_database_get()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'DATABASE GET "family" "key"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $client->databaseGet('family', 'key');
    }
    /**
     * @test
     */
    public function cannot_get_fullvariable()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'GET FULL VARIABLE "${some}" "channel"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $this->assertFalse($client->getFullVariable('some', 'channel'));
    }

    /**
     * @test
     */
    public function cannot_get_variable()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'GET VARIABLE "some"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $this->assertFalse($client->getVariable('some'));
    }
    /**
     * @test
     */
    public function can_get_variable()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'GET VARIABLE "some"'
        );
        $read = array(
            '200 result=1 (value)',
        );
        setFgetsMock($read, $write);
        $this->assertEquals($client->getVariable('some'), 'value');
    }
    /**
     * @test
     */
    public function can_get_channel_status()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'CHANNEL STATUS "channel"'
        );
        $read = array(
            '200 result=54',
        );
        setFgetsMock($read, $write);
        $this->assertEquals($client->channelStatus('channel'), 54);
    }
    /**
     * @test
     */
    public function can_set_music()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SET MUSIC off "class"'
        );
        $read = array(
            '200 result=1',
        );
        setFgetsMock($read, $write);
        $client->setMusic(false, 'class');
    }
    /**
     * @test
     */
    public function can_wait_digit()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'WAIT FOR DIGIT "3"'
        );
        $read = array(
            '200 result=65',
        );
        setFgetsMock($read, $write);
        $result = $client->waitDigit(3);
        $this->assertEquals($result->getDigits(), 'A');
        $this->assertEquals($result->getDigitsCount(), 1);
        $this->assertFalse($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_wait_digit_and_timeout()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'WAIT FOR DIGIT "3"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->waitDigit(3);
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\ChannelDownException
     */
    public function cannot_wait_digit()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'WAIT FOR DIGIT "3"'
        );
        $read = array(
            '200 result=-1',
        );
        setFgetsMock($read, $write);
        $result = $client->waitDigit(3);
    }
    /**
     * @test
     */
    public function can_stream_file()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'STREAM FILE "file" "#"'
        );
        $read = array(
            '200 result=0 endpos=123',
        );
        setFgetsMock($read, $write);
        $result = $client->streamFile('file', '#');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_say_datetime()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SAY DATETIME "time" "escape" "format"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sayDateTime('time', 'format', 'escape');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_say_digits()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SAY DIGITS "digits" "escape"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sayDigits('digits', 'escape');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_say_number()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SAY NUMBER "number" "escape"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sayNumber('number', 'escape');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_say_phonetic()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SAY PHONETIC "blah" "escape"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sayPhonetic('blah', 'escape');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_say_alpha()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SAY ALPHA "blah" "escape"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sayAlpha('blah', 'escape');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_say_date()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SAY DATE "date" "escape"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sayDate('date', 'escape');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_say_time()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'SAY TIME "time" "escape"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sayTime('time', 'escape');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_get_data()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'GET DATA "file" "maxtime" "maxdigits"'
        );
        $read = array(
            '200 result=123 (timeout)',
        );
        setFgetsMock($read, $write);
        $result = $client->getData('file', 'maxtime', 'maxdigits');
        $this->assertEquals($result->getDigitsCount(), 3);
        $this->assertTrue($result->isTimeout());
        $this->assertEquals($result->getDigits(), 123);
        $this->assertEquals($result->getCode(), 200);
        $this->assertEquals($result->getResult(), '123');
        $this->assertTrue($result->isResult(123));
        $this->assertTrue($result->hasData());
        $this->assertEquals($result->getData(), '(timeout)');
        $this->assertEquals($result->getOriginalLine(), '200 result=123 (timeout)');
        $this->assertEquals($result->__toString(), '[ Result for |200 result=123 (timeout)| code: |200| result: |123| data: |(timeout)|]');
    }
    /**
     * @test
     */
    public function can_get_option()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'GET OPTION "file" "escape" "maxdigits"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->getOption('file', 'escape', 'maxdigits');
        $this->assertTrue($result->isTimeout());
    }
    /**
     * @test
     */
    public function can_record()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'RECORD FILE "file" "format" "escape" "maxtime" "s=123"'
        );
        $read = array(
            '200 result=65 (dtmf) endpos=666',
        );
        setFgetsMock($read, $write);
        $result = $client->record('file', 'format', 'escape', 'maxtime', 123);
        $this->assertTrue($result->isInterrupted());
        $this->assertEquals($result->getDigits(), 'A');
        $this->assertEquals($result->getEndPos(), 666);
        $this->assertFalse($result->isHangup());
    }
    /**
     * @test
     */
    public function can_record_and_detect_hangup()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'RECORD FILE "file" "format" "escape" "maxtime" "s=123"'
        );
        $read = array(
            '200 result=0 (hangup) endpos=666',
        );
        setFgetsMock($read, $write);
        $result = $client->record('file', 'format', 'escape', 'maxtime', 123);
        $this->assertTrue($result->isInterrupted());
        $this->assertEquals($result->getEndPos(), 666);
        $this->assertTrue($result->isHangup());
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\RecordException
     */
    public function cannot_record_writefile()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'RECORD FILE "file" "format" "escape" "maxtime" "s=123"'
        );
        $read = array(
            '200 result=65 (dtmf) (writefile) endpos=666',
        );
        setFgetsMock($read, $write);
        $result = $client->record('file', 'format', 'escape', 'maxtime', 123);
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\RecordException
     */
    public function cannot_record_waitfor()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'RECORD FILE "file" "format" "escape" "maxtime" "s=123"'
        );
        $read = array(
            '200 result=65 (dtmf) (waitfor) endpos=666',
        );
        setFgetsMock($read, $write);
        $result = $client->record('file', 'format', 'escape', 'maxtime', 123);
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\SoundFileException
     */
    public function cannot_stream_file()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'STREAM FILE "file" "#"'
        );
        $read = array(
            '200 result=0 endpos=0',
        );
        setFgetsMock($read, $write);
        $result = $client->streamFile('file', '#');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\PAGIException
     */
    public function cannot_fwrite()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'fwrite error'
        );
        $read = array(
            '200 result=0 endpos=0'
        );
        setFgetsMock($read, $write);
        $result = $client->streamFile('file', '#');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\ChannelDownException
     */
    public function cannot_do_anything_on_channel_down()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'STREAM FILE "file" "#"'
        );
        $read = array(
            '511 result=0 endpos=0'
        );
        setFgetsMock($read, $write);
        $result = $client->streamFile('file', '#');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\InvalidCommandException
     */
    public function cannot_do_anything_on_invalid_command()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'STREAM FILE "file" "#"'
        );
        $read = array(
            '510 result=0 endpos=0'
        );
        setFgetsMock($read, $write);
        $result = $client->streamFile('file', '#');
    }
    /**
     * @test
     * @expectedException \PAGI\Exception\ExecuteCommandException
     */
    public function cannot_execute()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "a" "b"',
        );
        $read = array(
            '200 result=-2 endpos=0',
        );
        setFgetsMock($read, $write);
        $result = $client->exec('a', array('b'));
    }
    /**
     * @test
     */
    public function can_dial_and_return_busy()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Dial" "channel,a,b,c"',
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (DIALEDPEERNAME)',
        	'200 result=1 (DIALEDPEERNUMBER)',
        	'200 result=1 (ANSWEREDTIME)',
        	'200 result=1 (BUSY)',
        	'200 result=1 (DYNAMIC_FEATURES)',
        );
        setFgetsMock($read, $write);
        $mockTime = true;
        $mockTimeReturn = array(time() - 10, time());
        $result = $client->dial('channel', array('a', 'b', 'c'));
        $mockTime = false;
        $this->assertTrue($result->isBusy());
    }
    /**
     * @test
     */
    public function can_dial_and_return_answer()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Dial" "channel,a,b,c"',
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (DIALEDPEERNAME)',
        	'200 result=1 (DIALEDPEERNUMBER)',
        	'200 result=1 (ANSWEREDTIME)',
        	'200 result=1 (ANSWER)',
        	'200 result=1 (DYNAMIC_FEATURES)',
        );
        setFgetsMock($read, $write);
        $mockTime = true;
        $mockTimeReturn = array(time() - 10, time());
        $result = $client->dial('channel', array('a', 'b', 'c'));
        $mockTime = false;
        $this->assertTrue($result->isAnswer());
    }
    /**
     * @test
     */
    public function can_dial_and_return_congestion()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Dial" "channel,a,b,c"',
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (DIALEDPEERNAME)',
        	'200 result=1 (DIALEDPEERNUMBER)',
        	'200 result=1 (ANSWEREDTIME)',
        	'200 result=1 (CONGESTION)',
        	'200 result=1 (DYNAMIC_FEATURES)',
        );
        setFgetsMock($read, $write);
        $mockTime = true;
        $mockTimeReturn = array(time() - 10, time());
        $result = $client->dial('channel', array('a', 'b', 'c'));
        $mockTime = false;
        $this->assertTrue($result->isCongestion());
    }
    /**
     * @test
     */
    public function can_dial_and_return_cancel()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Dial" "channel,a,b,c"',
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (DIALEDPEERNAME)',
        	'200 result=1 (DIALEDPEERNUMBER)',
        	'200 result=1 (ANSWEREDTIME)',
        	'200 result=1 (CANCEL)',
        	'200 result=1 (DYNAMIC_FEATURES)',
        );
        setFgetsMock($read, $write);
        $mockTime = true;
        $mockTimeReturn = array(time() - 10, time());
        $result = $client->dial('channel', array('a', 'b', 'c'));
        $mockTime = false;
        $this->assertTrue($result->isCancel());
    }
    /**
     * @test
     */
    public function can_dial_and_return_noanswer()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Dial" "channel,a,b,c"',
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (DIALEDPEERNAME)',
        	'200 result=1 (DIALEDPEERNUMBER)',
        	'200 result=1 (ANSWEREDTIME)',
        	'200 result=1 (NOANSWER)',
        	'200 result=1 (DYNAMIC_FEATURES)',
        );
        setFgetsMock($read, $write);
        $mockTime = true;
        $mockTimeReturn = array(time() - 10, time());
        $result = $client->dial('channel', array('a', 'b', 'c'));
        $mockTime = false;
        $this->assertTrue($result->isNoAnswer());
    }
    /**
     * @test
     */
    public function can_dial_and_return_chanunavail()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Dial" "channel,a,b,c"',
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (DIALEDPEERNAME)',
        	'200 result=1 (DIALEDPEERNUMBER)',
        	'200 result=1 (ANSWEREDTIME)',
        	'200 result=1 (CHANUNAVAIL)',
        	'200 result=1 (DYNAMIC_FEATURES)',
        );
        setFgetsMock($read, $write);
        $mockTime = true;
        $mockTimeReturn = array(time() - 10, time());
        $result = $client->dial('channel', array('a', 'b', 'c'));
        $mockTime = false;
        $this->assertTrue($result->isChanUnavailable());
    }
    /**
     * @test
     */
    public function can_dial()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Dial" "channel,a,b,c"',
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (DIALEDPEERNAME)',
        	'200 result=1 (DIALEDPEERNUMBER)',
        	'200 result=1 (ANSWEREDTIME)',
        	'200 result=1 (DIALSTATUS)',
        	'200 result=1 (DYNAMIC_FEATURES)',
        );
        setFgetsMock($read, $write);
        $mockTime = true;
        $mockTimeReturn = array(time() - 10, time());
        $result = $client->dial('channel', array('a', 'b', 'c'));
        $mockTime = false;
        $this->assertEquals($result->getDynamicFeatures(), 'DYNAMIC_FEATURES');
        $this->assertEquals($result->getDialStatus(), 'DIALSTATUS');
        $this->assertEquals($result->getAnsweredTime(), 'ANSWEREDTIME');
        $this->assertEquals($result->getPeerNumber(), 'DIALEDPEERNUMBER');
        $this->assertEquals($result->getPeerName(), 'DIALEDPEERNAME');
        $this->assertEquals($result->getDialedTime(), 10);
        $this->assertEquals($result->__toString(), '[ Dial:  PeerName: DIALEDPEERNAME PeerNumber: DIALEDPEERNUMBER DialedTime: 10 AnsweredTime: ANSWEREDTIME DialStatus: DIALSTATUS Features: DYNAMIC_FEATURES ]');
    }
    /**
     * @test
     */
    public function can_receive_fax()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "ReceiveFax" "file.tiff"',
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=1',
            '200 result=1 (SUCCESS)',
        	'200 result=1 (FAXBITRATE)',
        	'200 result=1 (FAXRESOLUTION)',
        	'200 result=1 (FAXPAGES)',
        	'200 result=1 (FAXERROR)',
        	'200 result=1 (REMOTESTATIONID)',
        	'200 result=1 (LOCALSTATIONID)',
        	'200 result=1 (LOCALHEADERINFO)',
        );
        setFgetsMock($read, $write);
        $result = $client->faxReceive('file.tiff');
        $this->assertTrue($result->isSuccess());
        $this->assertEquals($result->getBitrate(), 'FAXBITRATE');
        $this->assertEquals($result->getResolution(), 'FAXRESOLUTION');
        $this->assertEquals($result->getPages(), 'FAXPAGES');
        $this->assertEquals($result->getError(), 'FAXERROR');
        $this->assertEquals($result->getRemoteStationId(), 'REMOTESTATIONID');
        $this->assertEquals($result->getLocalStationId(), 'LOCALSTATIONID');
        $this->assertEquals($result->getLocalHeaderInfo(), 'LOCALHEADERINFO');
        $this->assertEquals($result->__toString(), '[ FaxResult:  Resolution: FAXRESOLUTION Bitrate: 0 Pages: 0 LocalId: LOCALSTATIONID LocalHeader: LOCALHEADERINFO RemoteId: REMOTESTATIONID Error: FAXERROR Result: Success]');
    }
    /**
     * @test
     */
    public function can_stop_playing_tones()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "StopPlayTones" ""'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->stopPlayingTones();
    }
    /**
     * @test
     */
    public function can_play_tone()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "PlayTones" "busy"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->playTone('busy');
    }
    /**
     * @test
     */
    public function can_play_busy_tone()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "PlayTones" "Busy"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->playBusyTone();
    }
    /**
     * @test
     */
    public function can_play_dial_tone()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "PlayTones" "dial"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->playDialTone();
    }
    /**
     * @test
     */
    public function can_play_congestion_tone()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "PlayTones" "Congestion"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->playCongestionTone();
    }
    /**
     * @test
     */
    public function can_play_custom_tones()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "PlayTones" "425/50,0/50"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->playCustomTones(array("425/50","0/50"));
    }
    /**
     * @test
     */
    public function can_indicate_progress()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Progress" ""'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->indicateProgress();
    }
    /**
     * @test
     */
    public function can_indicate_busy()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Busy" "10"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->indicateBusy(10);
    }
    /**
     * @test
     */
    public function can_indicate_congestion()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "Congestion" "10"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->indicateCongestion(10);
    }
    /**
     * @test
     */
    public function can_send_fax()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
        	'EXEC "SendFax" "file.tiff,a"',
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            false
        );
        $read = array(
            '200 result=1',
            '200 result=1 (SUCCESS)',
        	'200 result=1 (FAXBITRATE)',
        	'200 result=1 (FAXRESOLUTION)',
        	'200 result=1 (FAXPAGES)',
        	'200 result=1 (FAXERROR)',
        	'200 result=1 (REMOTESTATIONID)',
        	'200 result=1 (LOCALSTATIONID)',
        	'200 result=1 (LOCALHEADERINFO)',
        );
        setFgetsMock($read, $write);
        $result = $client->faxSend('file.tiff');
        $this->assertTrue($result->isSuccess());
        $this->assertEquals($result->getBitrate(), 'FAXBITRATE');
        $this->assertEquals($result->getResolution(), 'FAXRESOLUTION');
        $this->assertEquals($result->getPages(), 'FAXPAGES');
        $this->assertEquals($result->getError(), 'FAXERROR');
        $this->assertEquals($result->getRemoteStationId(), 'REMOTESTATIONID');
        $this->assertEquals($result->getLocalStationId(), 'LOCALSTATIONID');
        $this->assertEquals($result->getLocalHeaderInfo(), 'LOCALHEADERINFO');
        $this->assertEquals($result->__toString(), '[ FaxResult:  Resolution: FAXRESOLUTION Bitrate: 0 Pages: 0 LocalId: LOCALSTATIONID LocalHeader: LOCALHEADERINFO RemoteId: REMOTESTATIONID Error: FAXERROR Result: Success]');
    }
    /**
     * @test
     */
    public function can_get_client()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
    }

    /**
     * @test
     */
    public function can_get_node()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $node = $client->createNode('name');
        $this->assertTrue($node->getClient() instanceof \PAGI\Client\Impl\ClientImpl);
        $this->assertEquals($node->getName(), 'name');
    }

    /**
     * @test
     */
    public function can_add_sip_header()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "SipAddHeader" "name: value"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sipHeaderAdd('name', 'value');
    }

    /**
     * @test
     */
    public function can_add_sip_remove()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "SipRemoveHeader" "name"'
        );
        $read = array(
            '200 result=0',
        );
        setFgetsMock($read, $write);
        $result = $client->sipHeaderRemove('name');
    }

    /**
     * @test
     */
    public function can_amd_send_options()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "AMD" "a,b,c,d,e,f,g,h,i"',
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (A)',
            '200 result=1 (B)'
        );
        setFgetsMock($read, $write);
        $result = $client->amd(array(
            'initialSilence' => 'a',
            'greeting' => 'b',
            'afterGreetingSilence' => 'c',
            'totalAnalysisTime' => 'd',
            'miniumWordLength' => 'e',
            'betweenWordSilence' => 'f',
            'maximumNumberOfWords' => 'g',
            'silenceThreshold' => 'h',
            'maximumWordLength' => 'i'
        ));
        $this->assertEquals($result->getStatus(), 'A');
        $this->assertEquals($result->getCause(), 'B');
        $this->assertEquals($result->__toString(), '[ Amd:  Status: A Cause: B ]');
    }

    /**
     * @test
     */
    public function can_amd_detect_human()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "AMD" ",,,,,,,,"',
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (HUMAN)',
            '200 result=1 (HUMAN)'
        );
        setFgetsMock($read, $write);
        $result = $client->amd();
        $this->assertTrue($result->isHuman());
        $this->assertTrue($result->isCauseHuman());
    }

    /**
     * @test
     */
    public function can_amd_detect_machine()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "AMD" ",,,,,,,,"',
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (MACHINE)',
            '200 result=1 (LONGGREETING)'
        );
        setFgetsMock($read, $write);
        $result = $client->amd();
        $this->assertTrue($result->isMachine());
        $this->assertTrue($result->isCauseGreeting());
    }

    /**
     * @test
     */
    public function can_amd_unsure()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "AMD" ",,,,,,,,"',
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (NOTSURE)',
            '200 result=1 (MAXWORDLENGTH)'
        );
        setFgetsMock($read, $write);
        $result = $client->amd();
        $this->assertTrue($result->isNotSure());
        $this->assertTrue($result->isCauseWordLength());
    }

    /**
     * @test
     */
    public function can_amd_hangup()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "AMD" ",,,,,,,,"',
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (HANGUP)',
            '200 result=1 (INITIALSILENCE)'
        );
        setFgetsMock($read, $write);
        $result = $client->amd();
        $this->assertTrue($result->isHangup());
        $this->assertTrue($result->isCauseInitialSilence());
    }

    /**
     * @test
     */
    public function can_amd_cause_too_long()
    {
        global $standardAGIStart;
        global $mockTime;
        global $mockTimeReturn;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $write = array(
            'EXEC "AMD" ",,,,,,,,"',
            false,
            false
        );
        $read = array(
            '200 result=0 endpos=0',
            '200 result=1 (NOTSURE)',
            '200 result=1 (TOOLONG)'
        );
        setFgetsMock($read, $write);
        $result = $client->amd();
        $this->assertTrue($result->isNotSure());
        $this->assertTrue($result->isCauseTooLong());
    }

}
}
