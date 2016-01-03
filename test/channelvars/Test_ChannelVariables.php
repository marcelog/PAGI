<?php
/**
 * This class will test the channel variables.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Channelvars
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
 * This class will test the channel variables.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Channelvars
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_ChannelVariables extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array();
    }

    /**
     * @test
     */
    public function can_get_channel_variables()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $vars = $client->getChannelVariables();
        $vars = $client->getChannelVariables(); // should return the same instance
    }

    /**
     * @test
     */
    public function can_get_agi_variables()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $vars = $client->getChannelVariables();
        $this->assertEquals($vars->getChannel(), 'SIP/jondoe-7026f150');
        $this->assertEquals($vars->getLanguage(), 'ar');
        $this->assertEquals($vars->getType(), 'SIP');
        $this->assertEquals($vars->getUniqueId(), '1306865753.2488');
        $this->assertEquals($vars->getVersion(), '1.6.0.9');
        $this->assertEquals($vars->getCallerId(), '666');
        $this->assertEquals($vars->getCallerIdName(), 'JonDoe');
        $this->assertEquals($vars->getCallingPres(), '1');
        $this->assertEquals($vars->getCallingAni2(), '0');
        $this->assertEquals($vars->getCallingTon(), '0');
        $this->assertEquals($vars->getCallingTns(), '0');
        $this->assertEquals($vars->getDNID(), '66666666');
        $this->assertEquals($vars->getRDNIS(), 'unknown');
        $this->assertEquals($vars->getDNIS(), '55555555');
        $this->assertEquals($vars->getContext(), 'netlabs');
        $this->assertEquals($vars->getRequest(), 'anagi.php');
        $this->assertEquals($vars->getThreadId(), '1105672528');
        $this->assertEquals($vars->getAccountCode(), '123');
        $this->assertEquals($vars->getEnhanced(), '0.0');
        $this->assertEquals($vars->getPriority(), '1');
        $this->assertEquals($vars->getTotalArguments(), 2);
        $this->assertEquals($vars->getArgument(1), 'arg1');
        $this->assertEquals($vars->getArgument(2), 'arg2');
        $this->assertEquals(array(1 => 'arg1', 2 => 'arg2'), $vars->getArguments());
        $this->assertFalse($vars->getArgument(3));
        $refObject = new \ReflectionObject($vars);
        $refMethod = $refObject->getMethod('getAGIVariable');
        $refMethod->setAccessible(true);
        $this->assertFalse($refMethod->invoke($vars, 'unexistant'));
    }
    /**
     * @test
     */
    public function can_get_environment_variables()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        putenv('AST_CONFIG_DIR=1');
        putenv('AST_CONFIG_FILE=2');
        putenv('AST_MODULE_DIR=3');
        putenv('AST_SPOOL_DIR=4');
        putenv('AST_MONITOR_DIR=5');
        putenv('AST_VAR_DIR=6');
        putenv('AST_DATA_DIR=7');
        putenv('AST_LOG_DIR=8');
        putenv('AST_AGI_DIR=9');
        putenv('AST_KEY_DIR=10');
        putenv('AST_RUN_DIR=11');
        $vars = $client->getChannelVariables();
        $this->assertEquals($vars->getDirectoryRun(), 11);
        $this->assertEquals($vars->getDirectoryKey(), 10);
        $this->assertEquals($vars->getDirectoryAgi(), 9);
        $this->assertEquals($vars->getDirectoryLog(), 8);
        $this->assertEquals($vars->getDirectoryData(), 7);
        $this->assertEquals($vars->getDirectoryVar(), 6);
        $this->assertEquals($vars->getDirectoryMonitor(), 5);
        $this->assertEquals($vars->getDirectorySpool(), 4);
        $this->assertEquals($vars->getDirectoryModules(), 3);
        $this->assertEquals($vars->getConfigFile(), 2);
        $this->assertEquals($vars->getDirectoryConfig(), 1);
    }
}
}
