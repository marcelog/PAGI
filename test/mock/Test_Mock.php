<?php
/**
 * This class will test the agi client mock
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Mock
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
use PAGI\Node\MockedNode;
use PAGI\Node\Node;

/**
 * This class will test the agi client mock
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Mock
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_Mock extends PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array(
            'variables' => array(),
            'resultStrings' => array()
        );
    }

    /**
     * @test
     * @expectedException PAGI\Exception\MockedException
     */
    public function cannot_respond_if_no_onMethod_was_defined_first()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $result = $mock->streamFile('blah', '01234567890*#');
    }

    /**
     * @test
     * @expectedException PAGI\Exception\MockedException
     */
    public function can_assert_number_of_arguments()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->assert('streamFile', array('blah', '*'));
        $mock->streamFile('blah');
    }

    /**
     * @test
     * @expectedException PAGI\Exception\MockedException
     */
    public function can_assert_arguments_equality()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->assert('waitDigit', array(1000));
        $mock->waitDigit(100);
    }

    /**
     * @test
     * @expectedException PAGI\Exception\MockedException
     */
    public function cannot_finish_without_using_all_results()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onDial(true, 'name', '123456', 20, 'ANSWER', '#blah');
        unset($mock);
    }

    /**
     * @test
     * @expectedException PAGI\Exception\MockedException
     */
    public function cannot_finish_without_using_all_asserts()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->assert('waitDigit', array(1));
        unset($mock);
    }
    /**
     * @test
     */
    public function can_dial_success()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onDial(true, 'name', '123456', 20, 'ANSWER', '#blah');
        $result = $mock->dial('SIP/blah', array(60, 'tH'));
        $this->assertTrue($result->isAnswer());
        $this->assertTrue($result->isResult(0));
    }
    /**
     * @test
     */
    public function can_dial_failed()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onDial(false, 'name', '123456', 20, 'CONGESTION', '#blah');
        $result = $mock->dial('SIP/blah', array(60, 'tH'));
        $this->assertTrue($result->isCongestion());
        $this->assertTrue($result->isResult(-1));
    }
    /**
     * @test
     */
    public function can_get_full_variable_failed()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onGetFullVariable(false);
        $this->assertFalse($mock->getFullVariable('whatever'));
    }
    /**
     * @test
     */
    public function can_get_full_variable_success()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onGetFullVariable(true, 'value');
        $this->assertEquals($mock->getFullVariable('whatever'), 'value');
    }
    /**
     * @test
     */
    public function can_get_variable_failed()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onGetVariable(false);
        $this->assertFalse($mock->getVariable('whatever'));
    }
    /**
     * @test
     */
    public function can_get_variable_success()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onGetVariable(true, 'value');
        $this->assertEquals($mock->getVariable('whatever'), 'value');
    }
    /**
     * @test
     */
    public function can_record_with_hangup()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onRecord(false, true, '#', 0);
        $result = $mock->record('blah', 'wav', '#');
        $this->assertTrue($result->isHangup());
        $this->assertTrue($result->isInterrupted());
    }
    /**
     * @test
     */
    public function can_record_with_interrupt()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onRecord(true, false, '#', 0);
        $result = $mock->record('blah', 'wav', '#');
        $this->assertFalse($result->isHangup());
        $this->assertTrue($result->isInterrupted());
        $this->assertEquals($result->getDigits(), '#');
    }

    /**
     * @test
     */
    public function can_get_option_without_interrupt()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onGetOption(false, '#', 1000);
        $result = $mock->getOption('blah', '#', 1000);
        $this->assertTrue($result->isTimeout());
    }

    /**
     * @test
     */
    public function can_get_option_with_interrupt()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onGetOption(true, '#', 1000);
        $result = $mock->getOption('blah', '#', 1000);
        $this->assertFalse($result->isTimeout());
        $this->assertEquals($result->getDigits(), '#');
    }

    /**
     * @test
     */
    public function can_record_with_timeout()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onRecord(false, false, '#', 0);
        $result = $mock->record('blah', 'wav', '#');
        $this->assertFalse($result->isHangup());
        $this->assertFalse($result->isInterrupted());
    }
    /**
     * @test
     */
    public function can_example_mock()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock
            ->assert('waitDigit', array(1000))
            ->assert('streamFile', array('blah', '01234567890*#'))
            ->assert('getData', array('blah', 123, '#'))
            ->assert('sayDateTime', array('asd', 123))
            ->assert('setVariable', array('asd', 'asd'))
            ->assert('setCallerId', array('name', 'number'))
            ->assert('playBusyTone')
            ->assert('playDialTone')
            ->assert('playCongestionTone')
            ->assert('stopPlayingTones')
            ->assert('playTone', array('some'))
            ->assert('playCustomTones', array(1, 2, 3))
            ->assert('amd', array())
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
            ->onAmd('status', 'cause')
            ->onHangup(true)
            ->onChannelStatus(PAGI\Client\ChannelStatus::LINE_UP)
        ;

        $mock->answer();
        $mock->waitDigit(1000);
        $mock->waitDigit(1000);
        $mock->streamFile('blah', '01234567890*#');
        $mock->streamFile('blah', '01234567890*#');
        $mock->getData('blah', 123, '#');
        $mock->getData('blah', 123, '#');
        $mock->sayDate('asd', time());
        $mock->sayTime('asd', time());
        $mock->sayDateTime('asd', 123);
        $mock->sayAlpha('asd');
        $mock->sayPhonetic('asd');
        $mock->sayNumber(123);
        $mock->sayDigits(123);
        $mock->amd();
        $mock->hangup();
        $mock->channelStatus();
        $mock->setCallerId('name', 'number');
        $mock->playBusyTone();
        $mock->playDialTone();
        $mock->playCongestionTone();
        $mock->stopPlayingTones();
        $mock->playTone('some');
        $mock->playCustomTones(array(1, 2, 3));
        $mock->consoleLog("blah");
        $mock->log("blah");
        $mock->setVariable('asd', 'asd');
        $mock->setContext('context');
        $mock->setExtension('extension');
        $mock->setPriority(1);
        $mock->setMusic(true);
    }

    /**
     * @test
     */
    public function can_get_unknown_node()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $this->assertTrue($mock->createNode('test') instanceof Node);
    }

    /**
     * @test
     */
    public function can_get_knownmocked_node()
    {
        $mock = new PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $mock->onCreateNode('test')->runWithInput('*');
        $this->assertTrue($mock->createNode('test') instanceof MockedNode);

    }
}