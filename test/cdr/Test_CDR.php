<?php
/**
 * This class will test the cdr.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Cdr
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
 * This class will test the cdr.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Cdr
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_CDR extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array();
    }

    /**
     * @test
     */
    public function can_get_cdr()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $vars = $client->getCDR();
        $vars = $client->getCDR(); // should return the same instance
    }
    /**
     * @test
     */
    public function can_set_cdr_variables()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $cdr = $client->getCDR();
        $cdrW = array(
        	'SET VARIABLE "CDR(userfield)" "pepe"',
        	'SET VARIABLE "CDR(accountcode)" "acc"',
        );
        $cdrR = array(
            '200 result=1',
        	'200 result=1',
        );
        setFgetsMock($cdrR, $cdrW);
        $cdr->setUserfield('pepe');
        $cdr->setAccountCode('acc');
    }
    /**
     * @test
     */
    public function can_get_cdr_variables()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $client = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $cdr = $client->getCDR();
        $cdrW = array(
        	'GET FULL VARIABLE "${CDR(dcontext)}"',
        	'GET FULL VARIABLE "${CDR(dstchannel)}"',
        	'GET FULL VARIABLE "${CDR(dst)}"',
        	'GET FULL VARIABLE "${CDR(src)}"',
        	'GET FULL VARIABLE "${CDR(clid)}"',
        	'GET FULL VARIABLE "${CDR(channel)}"',
        	'GET FULL VARIABLE "${CDR(lastapp)}"',
            'GET FULL VARIABLE "${CDR(lastdata)}"',
        	'GET FULL VARIABLE "${CDR(userfield)}"',
        	'GET FULL VARIABLE "${CDR(uniqueid)}"',
        	'GET FULL VARIABLE "${CDR(accountcode)}"',
        	'GET FULL VARIABLE "${CDR(amaflags)}"',
        	'GET FULL VARIABLE "${CDR(start)}"',
        	'GET FULL VARIABLE "${CDR(answer)}"',
        	'GET FULL VARIABLE "${CDR(end)}"',
        	'GET FULL VARIABLE "${CDR(duration)}"',
        	'GET FULL VARIABLE "${CDR(billsec)}"',
        	'GET FULL VARIABLE "${CDR(disposition)}"',
        );
        $cdrR = array(
            '200 result=1 "dcontext"',
        	'200 result=1 "dchannel"',
        	'200 result=1 "dst"',
        	'200 result=1 "src"',
        	'200 result=1 "clid"',
        	'200 result=1 "channel"',
        	'200 result=1 "lastapp"',
        	'200 result=1 "lastdata"',
        	'200 result=1 "userfield"',
        	'200 result=1 "uniqueid"',
        	'200 result=1 "accountcode"',
        	'200 result=1 "amaflags"',
        	'200 result=1 "start"',
        	'200 result=1 "answer"',
        	'200 result=1 "end"',
        	'200 result=1 "duration"',
        	'200 result=1 "billsec"',
        	'200 result=1 "disposition"',
        );
        setFgetsMock($cdrR, $cdrW);
        $this->assertEquals($cdr->getDestinationContext(), 'dcontext');
        $this->assertEquals($cdr->getDestinationChannel(), 'dchannel');
        $this->assertEquals($cdr->getDestination(), 'dst');
        $this->assertEquals($cdr->getSource(), 'src');
        $this->assertEquals($cdr->getCallerId(), 'clid');
        $this->assertEquals($cdr->getChannel(), 'channel');
        $this->assertEquals($cdr->getLastApp(), 'lastapp');
        $this->assertEquals($cdr->getLastAppData(), 'lastdata');
        $this->assertEquals($cdr->getUserfield(), 'userfield');
        $this->assertEquals($cdr->getUniqueId(), 'uniqueid');
        $this->assertEquals($cdr->getAccountCode(), 'accountcode');
        $this->assertEquals($cdr->getAMAFlags(), 'amaflags');
        $this->assertEquals($cdr->getStartTime(), 'start');
        $this->assertEquals($cdr->getAnswerTime(), 'answer');
        $this->assertEquals($cdr->getEndTime(), 'end');
        $this->assertEquals($cdr->getTotalLength(), 'duration');
        $this->assertEquals($cdr->getAnswerLength(), 'billsec');
        $this->assertEquals($cdr->getStatus(), 'disposition');
    }
}
}