<?php
/**
 * This class will test the callerid
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Callerid
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
 * This class will test the callerid
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Callerid
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_CallerID extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array();
    }

    /**
     * @test
     */
    public function can_set_callerid_pres()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $clid = $client->getCallerId();
        $callerIdW = array(
            'EXEC "SET" "CALLERPRES()=blah"'
        );
        $callerIdR = array(
            '200 result=1'
        );
        setFgetsMock($callerIdR, $callerIdW);
        $clid->setCallerPres("blah");
    }

    /**
     * @test
     */
    public function can_get_callerid()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $clid = $client->getCallerId();
        $clid = $client->getCallerId(); // should return the same instance
        $callerIdW = array(
        	'GET FULL VARIABLE "${CALLERID(num)}"',
        	'GET FULL VARIABLE "${CALLERID(name)}"',
        	'GET FULL VARIABLE "${CALLERID(dnid)}"',
        	'GET FULL VARIABLE "${CALLERID(rdnis)}"',
        	'GET FULL VARIABLE "${CALLERID(ani)}"'
        );
        $callerIdR = array(
            '200 result=1 "666"',
            '200 result=1 "pedro zamora"',
            '200 result=1 "444"',
            '200 result=1 "555"',
        	'200 result=1 "333"'
        );
        setFgetsMock($callerIdR, $callerIdW);
        $text = '[ CallerID:  number: 666 name: pedro zamora dnid: 444 rdnis: 555 ani: 333]';
        $this->assertEquals($text, $clid->__toString());
    }
    /**
     * @test
     */
    public function can_set_callerid()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $clid = $client->getCallerId();
        $callerIdW = array(
            'GET FULL VARIABLE "${CALLERID(name)}"',
        	'SET VARIABLE "CALLERID(num)" "666"',
            'SET VARIABLE "CALLERID(all)" "pepe zamora<666>"',
            'GET FULL VARIABLE "${CALLERID(num)}"',
        	'SET VARIABLE "CALLERID(name)" "pepe zamora"',
            'SET VARIABLE "CALLERID(all)" "pepe zamora<666>"',
        	'SET VARIABLE "CALLERID(ani)" "222"',
        	'SET VARIABLE "CALLERID(rdnis)" "333"',
        	'SET VARIABLE "CALLERID(dnid)" "555"',
        );
        $callerIdR = array(
            '200 result=1 "pepe zamora"',
            '200 result=1',
            '200 result=1',
        	'200 result=1 "666"',
        	'200 result=1',
            '200 result=1',
        	'200 result=1',
        	'200 result=1',
            '200 result=1',
        );
        setFgetsMock($callerIdR, $callerIdW);
        $clid->setNumber('666');
        $clid->setName('pepe zamora');
        $clid->setANI('222');
        $clid->setRDNIS('333');
        $clid->setDNID('555');
    }
}
}