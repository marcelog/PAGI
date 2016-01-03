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
namespace {
    $mockFopen = false;
    $mockTouch = false;
    $mockRename = false;
    $mockPutContents = false;
}

namespace PAGI\CallSpool\Impl {
    function tempnam() {
        global $mockTempnam;
        if (isset($mockTempnam) && $mockTempnam === true) {
            return false;
        } else {
            return call_user_func_array('\tempnam', func_get_args());
        }
    }
    function rename() {
        global $mockRename;
        if (isset($mockRename) && $mockRename === true) {
            return false;
        } else {
            return call_user_func_array('\rename', func_get_args());
        }
    }
    function touch() {
        global $mockTouch;
        if (isset($mockTouch) && $mockTouch === true) {
            return false;
        } else {
            return call_user_func_array('\touch', func_get_args());
        }
    }
    function file_put_contents() {
        global $mockPutContents;
        if (isset($mockPutContents) && $mockPutContents === true) {
            return false;
        } else {
            return call_user_func_array('\file_put_contents', func_get_args());
        }
    }

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
        global $mockTempnam;
        global $mockPutContents;
        global $mockTouch;
        global $mockRename;
        $mockTouch = false;
        $mockRename = false;
        $mockTempnam = false;
        $mockPutContents = false;
        $this->_properties = array();
    }

    /**
     * @test
     */
    public function can_create_callfile()
    {
        $call = new \PAGI\CallSpool\CallFile(new \PAGI\DialDescriptor\SIPDialDescriptor('target', 'provider'));
        $this->assertFalse($call->getArchive());
        $call->setArchive(true);
        $call->setContext('context');
        $call->setPriority('priority');
        $call->setExtension('extension');
        $call->setApplication('application');
        $call->setAlwaysDelete(true);
        $call->setCallerId('callerId');
        $call->setMaxRetries(33);
        $call->setRetryTime(44);
        $call->setWaitTime(22);
        $call->setVariable('var', 'value');
        $call->setAccount('account');
        $this->assertFalse($call->getApplicationData());
        $call->setApplicationData(array('a', 'b', 'c'));
        $this->assertTrue($call->getArchive());
        $this->assertEquals($call->getContext(), 'context');
        $this->assertEquals($call->getPriority(), 'priority');
        $this->assertEquals($call->getApplication(), 'application');
        $this->assertEquals($call->getExtension(), 'extension');
        $this->assertEquals($call->getMaxRetries(), 33);
        $this->assertEquals($call->getRetryTime(), 44);
        $this->assertEquals($call->getWaitTime(), 22);
        $this->assertTrue($call->getAlwaysDelete());
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
    /**
     * @test
     * @expectedException \PAGI\CallSpool\Exception\CallSpoolException
     */
    public function cannot_create_temp_file()
    {
        global $mockTempnam;
        $mockTempnam = true;
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . microtime(true);
        $spoolDir = $tmpDir . DIRECTORY_SEPARATOR . 'spool';
        $props = array('tmpDir' => $tmpDir, 'spoolDir' => $spoolDir);
        $call = new \PAGI\CallSpool\CallFile(new \PAGI\DialDescriptor\SIPDialDescriptor('target', 'provider'));
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props);
        $spool->spool($call);
    }
    /**
     * @test
     * @expectedException \PAGI\CallSpool\Exception\CallSpoolException
     */
    public function cannot_write_temp_file()
    {
        global $mockPutContents;
        global $mockTempnam;
        $mockTempnam = false;
        $mockPutContents = true;
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . microtime(true);
        $spoolDir = $tmpDir . DIRECTORY_SEPARATOR . 'spool';
        if (@mkdir($tmpDir, 0755, true) === false) {
            $this->fail('Could not create temporary directory');
        }
        if (@mkdir($spoolDir . DIRECTORY_SEPARATOR . 'outgoing', 0755, true) === false) {
            $this->fail('Could not create temporary spool directory');
        }
        $props = array('tmpDir' => $tmpDir, 'spoolDir' => $spoolDir);
        $call = new \PAGI\CallSpool\CallFile(new \PAGI\DialDescriptor\SIPDialDescriptor('target', 'provider'));
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props);
        $spool->spool($call);
    }
    /**
     * @test
     * @expectedException \PAGI\CallSpool\Exception\CallSpoolException
     */
    public function cannot_touch_temp_file()
    {
        global $mockTouch;
        $mockTouch = true;
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . microtime(true);
        $spoolDir = $tmpDir . DIRECTORY_SEPARATOR . 'spool';
        if (@mkdir($tmpDir, 0755, true) === false) {
            $this->fail('Could not create temporary directory');
        }
        if (@mkdir($spoolDir . DIRECTORY_SEPARATOR . 'outgoing', 0755, true) === false) {
            $this->fail('Could not create temporary spool directory');
        }
        $props = array('tmpDir' => $tmpDir, 'spoolDir' => $spoolDir);
        $call = new \PAGI\CallSpool\CallFile(new \PAGI\DialDescriptor\SIPDialDescriptor('target', 'provider'));
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props);
        $spool->spool($call, 12);
    }
    /**
     * @test
     * @expectedException \PAGI\CallSpool\Exception\CallSpoolException
     */
    public function cannot_move_file_to_spool()
    {
        global $mockRename;
        $mockRename = true;
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . microtime(true);
        $spoolDir = $tmpDir . DIRECTORY_SEPARATOR . 'spool';
        if (@mkdir($tmpDir, 0755, true) === false) {
            $this->fail('Could not create temporary directory');
        }
        if (@mkdir($spoolDir . DIRECTORY_SEPARATOR . 'outgoing', 0755, true) === false) {
            $this->fail('Could not create temporary spool directory');
        }
        $props = array('tmpDir' => $tmpDir, 'spoolDir' => $spoolDir);
        $call = new \PAGI\CallSpool\CallFile(new \PAGI\DialDescriptor\SIPDialDescriptor('target', 'provider'));
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props);
        $spool->spool($call, 12);
    }
    /**
     * @test
     */
    public function can_spool_and_schedule()
    {
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . microtime(true);
        $spoolDir = $tmpDir . DIRECTORY_SEPARATOR . 'spool';
        if (@mkdir($tmpDir, 0755, true) === false) {
            $this->fail('Could not create temporary directory');
        }
        if (@mkdir($spoolDir . DIRECTORY_SEPARATOR . 'outgoing', 0755, true) === false) {
            $this->fail('Could not create temporary spool directory');
        }
        $props = array('tmpDir' => $tmpDir, 'spoolDir' => $spoolDir);
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props);
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

        $file = $spool->spool($call, 12);
        $content = <<<TEXT
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
;
        $this->assertEquals(file_get_contents($file), $content);
        $this->assertEquals(filemtime($file), 12);
        if (@unlink($file) === false) {
            $this->fail('could not remove call file: ' . $file);
        }
        if (@rmdir($spoolDir . DIRECTORY_SEPARATOR . 'outgoing') === false) {
            $this->fail('could not remove temporary spool outgoing directory');
        }
        if (@rmdir($spoolDir) === false) {
            $this->fail('could not remove temporary spool directory');
        }
        if (@rmdir($tmpDir) === false) {
            $this->fail('could not remove temporary directory');
        }
    }
}
}