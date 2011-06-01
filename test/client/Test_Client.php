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
        $callerIdW = array(
        	'ANSWER'
        );
        $callerIdR = array(
            '200 result=1',
        );
        setFgetsMock($callerIdR, $callerIdW);
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
        $callerIdW = array(
        	'HANGUP',
        	'HANGUP "somechannel"'
	    );
        $callerIdR = array(
            '200 result=1',
        	'200 result=1',
        );
        setFgetsMock($callerIdR, $callerIdW);
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
        $callerIdW = array(
        	'ANSWER'
        );
        $callerIdR = array(
            '200 result=-1',
        );
        setFgetsMock($callerIdR, $callerIdW);
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
        $callerIdW = array(
        	'HANGUP'
        );
        $callerIdR = array(
            '200 result=-1',
        );
        setFgetsMock($callerIdR, $callerIdW);
        $client->hangup();
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