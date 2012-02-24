<?php
/**
 * An AGI client implementation useful for mocking and testing ivr apps.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/PAGI/
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
namespace PAGI\Client\Impl;

use PAGI\Client\AbstractClient;
use PAGI\Exception\MockedException;

/**
 * An AGI client implementation useful for mocking and testing ivr apps.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class MockedClientImpl extends AbstractClient
{
    /**
     * Mocked result strings.
     * @var string[]
     */
    private $mockedResultStrings;

    /**
     * Result counter.
     * @var integer
     */
    private $resultCounter = -1;

    private $methodCallAsserts = array();

    protected function send($text)
    {
        $this->resultCounter++;
        if (empty($this->mockedResultStrings)) {
            throw new MockedException("Dont know how to respond to $text");
        }
        $result = array_shift($this->mockedResultStrings);
        return $this->getResultFromResultString($result);
    }

    protected function open()
    {
        return;
    }

    protected function close()
    {
        if (!empty($this->mockedResultStrings)) {
            echo "Some results were not used: " . print_r($this->mockedResultStrings, true);
            throw new MockedException(
            	"Some results were not used: " . print_r($this->mockedResultStrings, true)
            );
        }
        if (!empty($this->methodCallAsserts)) {
            echo "Some methods were not called: " . print_r($this->methodCallAsserts, true);
            throw new MockedException(
            	"Some methods were not called: " . print_r($this->methodCallAsserts, true)
            );
        }
        return;
    }

    public function __destruct()
    {
        // @codeCoverageIgnoreStart
        $this->close();
        // @codeCoverageIgnoreEnd
    }

    public function addMockedResult($string)
    {
        $this->mockedResultStrings[] = $string;
        return $this;
    }

    public function assert($methodName, array $args = array())
    {
        if (!isset($this->methodCallAsserts[$methodName])) {
            $this->methodCallAsserts[$methodName] = array();
        }
        $this->methodCallAsserts[$methodName][] = $args;
        return $this;
    }

    private function assertCall($methodName, array $arguments)
    {
        if (!isset($this->methodCallAsserts[$methodName]) || empty($this->methodCallAsserts[$methodName])) {
            return true;
        }
        $args = array_shift($this->methodCallAsserts[$methodName]);
        if (empty($this->methodCallAsserts[$methodName])) {
            unset($this->methodCallAsserts[$methodName]);
        }
        $count = count($args);
        for ($i = 0; $i < $count; $i++) {
            if (!isset($arguments[$i])) {
                throw new MockedException("Missing argument number " . $i + 1);
            }
            $arg = $arguments[$i];
            if ($arg !== $args[$i]) {
                throw new MockedException(
                	"Arguments mismatch for $methodName: called with: " . print_r($arguments, true)
                    . " expected: " . print_r($args, true)
                );
            }
        }
        return true;
    }

    public function waitDigit($timeout)
    {
        $args = func_get_args();
        $this->assertCall('waitDigit', $args);
        return parent::waitDigit($timeout);
    }

    public function streamFile($file, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('streamFile', $args);
        return parent::streamFile($file, $escapeDigits);
    }

    public function dial($channel, array $options = array())
    {
        $args = func_get_args();
        $this->assertCall('dial', $args);
        return parent::dial($channel, $options);
    }

    public function getData($file, $maxTime, $maxDigits)
    {
        $args = func_get_args();
        $this->assertCall('getData', $args);
        return parent::getData($file, $maxTime, $maxDigits);
    }

    public function record($file, $format, $escapeDigits, $maxRecordTime = -1, $silence = false)
    {
        $args = func_get_args();
        $this->assertCall('record', $args);
        return parent::record($file, $format, $escapeDigits, $maxRecordTime, $silence);
    }

    public function sayTime($time, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('sayTime', $args);
        return parent::sayTime($time, $escapeDigits);
    }

    public function sayDate($time, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('sayDate', $args);
        return parent::sayDate($time, $escapeDigits);
    }

    public function sayDateTime($time, $format, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('sayDateTime', $args);
        return parent::sayDateTime($time, $format, $escapeDigits);
    }

    public function sayDigits($digits, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('sayDigits', $args);
        return parent::sayDigits($digits, $escapeDigits);
    }

    public function sayNumber($digits, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('sayNumber', $args);
        return parent::sayNumber($digits, $escapeDigits);
    }

    public function sayAlpha($what, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('sayAlpha', $args);
        return parent::sayAlpha($what, $escapeDigits);
    }

    public function sayPhonetic($what, $escapeDigits = '')
    {
        $args = func_get_args();
        $this->assertCall('sayPhonetic', $args);
        return parent::sayPhonetic($what, $escapeDigits);
    }

    public function getFullVariable($name, $channel = false)
    {
        $args = func_get_args();
        $this->assertCall('getFullVariable', $args);
        return parent::getFullVariable($name, $channel);
    }

    public function getVariable($name)
    {
        $args = func_get_args();
        $this->assertCall('getVariable', $args);
        return parent::getVariable($name);
    }

    public function setVariable($name, $value)
    {
        $args = func_get_args();
        $this->assertCall('setVariable', $args);
        return;
    }

    public function consoleLog($msg, $level = 1)
    {
        return;
    }

    public function log($msg, $priority = 'NOTICE')
    {
        return;
    }

    public function getOption($file, $escapeDigits, $maxTime)
    {
        $args = func_get_args();
        $this->assertCall('getOption', $args);
        return parent::getOption($file, $escapeDigits, $maxTime);
    }

    public function setCallerId($name, $number)
    {
        $args = func_get_args();
        $this->assertCall('setCallerId', $args);
    }

    public function onGetOption($interrupted, $digit = '#', $offset = 1)
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
            . " endpos=$offset"
        );
        return $this;
    }

    public function onWaitDigit($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onGetVariable($success, $value = '')
    {
        if ($success) {
            $this->addMockedResult('200 result=1 (' . $value . ')');
        } else {
            $this->addMockedResult('200 result=0');
        }
        return $this;
    }

    public function onGetFullVariable($success, $value = '')
    {
        if ($success) {
            $this->addMockedResult('200 result=1 (' . $value . ')');
        } else {
            $this->addMockedResult('200 result=0');
        }
        return $this;
    }

    public function onDial(
        $success, $peerName, $peerNumber, $answeredTime,
        $dialStatus, $dynamicFeatures
    ) {
        if ($success) {
            $this->addMockedResult('200 result=0');
        } else {
            $this->addMockedResult('200 result=-1');
        }
        $this->onGetVariable(true, $peerName);
        $this->onGetVariable(true, $peerNumber);
        $this->onGetVariable(true, $answeredTime);
        $this->onGetVariable(true, $dialStatus);
        $this->onGetVariable(true, $dynamicFeatures);
        return $this;
    }

    public function onRecord(
        $interrupted, $hangup, $digit, $endpos
    ) {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) . ' (dtmf)' : '0')
            . ($hangup ? ' (hangup)' : '')
            . " endpos=$endpos"
        );
        return $this;
    }

    public function onStreamFile($interrupted, $digit = '#', $offset = 1)
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
            . " endpos=$offset"
        );
        return $this;
    }

    public function onGetData($interrupted, $digits = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? $digits : ' (timeout)')
        );
        return $this;
    }

    public function onSayTime($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onSayDateTime($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onSayDate($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onSayNumber($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onSayDigits($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onSayPhonetic($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onSayAlpha($interrupted, $digit = '#')
    {
        $this->addMockedResult(
            '200 result='
            . ($interrupted ? ord($digit) : '0')
        );
        return $this;
    }

    public function onAnswer($success)
    {
        $this->addMockedResult(
            '200 result=' . ($success ? '0' : '-1')
        );
        return $this;
    }

    public function onHangup($success)
    {
        $this->addMockedResult(
            '200 result=' . ($success ? '0' : '-1')
        );
        return $this;
    }

    public function __construct(
        array $envVariables = array(), array $resultStrings = array()
    ) {
        $this->_variables = $envVariables;
        $this->mockedResultStrings = $resultStrings;
        $this->open();
    }
}