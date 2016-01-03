<?php
/**
 * This class will test the logger.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Logger
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
 * This class will test the logger.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Logger
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_AsteriskLogger extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array();
    }

    /**
     * @test
     */
    public function can_log()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $logger = $client->getAsteriskLogger();
        $write = array(
        	'EXEC "LOG" "NOTICE,log1"',
        	'EXEC "LOG" "WARNING,log2"',
        	'EXEC "LOG" "ERROR,log3"',
        	'EXEC "LOG" "DTMF,log4"',
        	'EXEC "LOG" "DEBUG,log5"',
        	'EXEC "LOG" "VERBOSE,log6"'
        );
        $read = array(
            '200 result=1',
        	'200 result=1',
        	'200 result=1',
        	'200 result=1',
        	'200 result=1',
        	'200 result=1',
        );
        setFgetsMock($read, $write);
        $logger->notice('log1');
        $logger->warn('log2');
        $logger->error('log3');
        $logger->dtmf('log4');
        $logger->debug('log5');
        $logger->verbose('log6');
    }
    /**
     * @test
     */
    public function can_get_logger()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $logger = $client->getAsteriskLogger();
        $logger = $client->getAsteriskLogger(); // should return the same instance.
    }

    /**
     * @test
     */
    public function can_mock_asterisk_logger()
    {
        $client = new \PAGI\Client\Impl\MockedClientImpl($this->_properties);
        $logger = $client->getAsteriskLogger();
        $logger->dtmf('test');
        $logger->error('test');
        $logger->warn('test');
        $logger->notice('test');
        $logger->debug('test');
        $logger->verbose('test');
    }
}
}