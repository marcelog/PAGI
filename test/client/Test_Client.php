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
namespace {
    $mockFopen = false;
    $mockFwrite = false;
    $mockFgets = false;
    $mockFgetsCount = 0;
    $mockFclose = false;
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
            return call_user_func_array('\fopen', func_get_args());
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
        $this->_properties = array(
            'log4php.properties' => RESOURCES_DIR . DIRECTORY_SEPARATOR . 'log4php.properties'
        );
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
        $this->assertTrue($result->isTimeout());
        $this->assertEquals($result->getDigits(), 123);
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
     */
    public function can_get_client()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties); //should return the same instance
    }
}
}