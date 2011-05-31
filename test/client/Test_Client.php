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
    $mockFgets = false;
    $mockFgetsCount = 0;
    $errorAGIRead = array(
		'agi_request:anagi.php',
		'agi_channel:SIP/jondoe-7026f150',
        false
    );
    $standardAGIStart = array(
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
}

namespace PAGI\Client\Impl {
    function fopen() {
        global $mockFopen;
        if (isset($mockFopen) && $mockFopen === true) {
            return true;
        } else {
            return call_user_func_array('\fopen', func_get_args());
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

    private function _setFgetsMock(array $returnValues)
    {
        global $mockFgets;
        global $mockFopen;
        global $mockFgetsCount;
        global $mockFgetsReturn;
        $mockFgets = true;
        $mockFopen = true;
        $mockFgetsCount = 0;
        $mockFgetsReturn = $returnValues;
    }

    /**
     * @test
     * @expectedException \PAGI\Exception\PAGIException
     */
    public function cannot_read()
    {
        global $errorAGIRead;
        $this->_setFgetsMock($errorAGIRead);
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
    }

    /**
     * @test
     */
    public function can_get_client()
    {
        global $standardAGIStart;
        $this->_setFgetsMock($standardAGIStart);
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
    }
}
}