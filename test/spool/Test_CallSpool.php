<?php
/**
 * This class will test the call spool.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Spool
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

namespace PAGI\Client\Impl {
/**
 * This class will test the call spool.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Spool
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_CallSpool extends \PHPUnit_Framework_TestCase
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
     */
    public function can_create_callfile()
    {
        $call = new \PAGI\CallSpool\CallFile(new \PAGI\DialDescriptor\SIPDialDescriptor('target', 'provider'));
        $this->assertFalse($call->getArchive());
        $call->setArchive('archive');
        $call->setContext('context');
        $call->setPriority('priority');
        $call->setExtension('extension');
        $call->setApplication('application');
        $call->setAlwaysDelete('alwaysDelete');
        $call->setCallerId('callerId');
        $call->setMaxRetries(33);
        $call->setRetryTime(44);
        $call->setWaitTime(22);
        $call->setVariable('var', 'value');
        $call->setAccount('account');
        $this->assertFalse($call->getApplicationData());
        $call->setApplicationData(array('a', 'b', 'c'));
        $this->assertEquals($call->getArchive(), 'archive');
        $this->assertEquals($call->getContext(), 'context');
        $this->assertEquals($call->getPriority(), 'priority');
        $this->assertEquals($call->getApplication(), 'application');
        $this->assertEquals($call->getExtension(), 'extension');
        $this->assertEquals($call->getMaxRetries(), 33);
        $this->assertEquals($call->getRetryTime(), 44);
        $this->assertEquals($call->getWaitTime(), 22);
        $this->assertEquals($call->getAlwaysDelete(), 'alwaysDelete');
        $this->assertEquals($call->getCallerId(), 'callerId');
        $this->assertEquals($call->getAccount(), 'account');
        $this->assertEquals($call->getChannel(), 'SIP/target@provider');
        $this->assertEquals($call->getVariable('var'), 'value');
        $this->assertFalse($call->getVariable('var2'));
        $this->assertEquals($call->getApplicationData(), array('a', 'b', 'c'));
        $this->assertEquals($call->serialize(), <<<TEXT
Channel: SIP/target@provider
Archive: Yes
Context: context
Priority: priority
Extension: extension
Application: application
AlwaysDelete: Yes
CallerID: callerId
MaxRetries: 33
RetryTime: 44
WaitTime: 22
Account: account
Data: a,b,c
Set: var=value
TEXT
);
        $call = new \PAGI\CallSpool\CallFile(new \PAGI\DialDescriptor\SIPDialDescriptor('target', 'provider'));
        $call->unserialize(<<<TEXT
Channel: SIP/target@provider

Archive: Yes
Context: context
Priority: priority
Extension: extension
Application: application
AlwaysDelete: Yes
CallerID: callerId
MaxRetries: 33
RetryTime: 44
WaitTime: 22
Account: account
Data: a,b,c
aaaa:
Set: var=value
Set: var2=
TEXT
);
        $this->assertEquals($call->serialize(), <<<TEXT
Channel: SIP/target@provider
Archive: Yes
Context: context
Priority: priority
Extension: extension
Application: application
AlwaysDelete: Yes
CallerID: callerId
MaxRetries: 33
RetryTime: 44
WaitTime: 22
Account: account
Data: a,b,c
aaaa: ?
Set: var=value
Set: var2=?
TEXT
);
    }
    /**
     * @test
     */
    public function can_get_instance()
    {
        $props = array(
            'tmpDir' => '/tmp',
            'spoolDir' => '/tmp'
        );
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props);
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props); // should return the same instance.
    }
}
}