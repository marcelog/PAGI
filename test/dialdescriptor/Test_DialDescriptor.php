<?php
/**
 * This class will test the dial descriptors.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Descriptor
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
 * This class will test the dial descriptors.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Descriptor
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_DialDescriptor extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array();
    }

    /**
     * @test
     */
    public function can_use_sip_descriptor()
    {
        $descriptor = new \PAGI\DialDescriptor\SIPDialDescriptor('666', 'provider');
        $this->assertEquals($descriptor->getTechnology(), 'SIP');
        $this->assertEquals($descriptor->getChannelDescriptor(), 'SIP/666@provider');
        $descriptor->setProvider('otherprovider');
        $this->assertEquals($descriptor->getChannelDescriptor(), 'SIP/666@otherprovider');
    }
    /**
     * @test
     */
    public function can_use_dahdi_descriptor()
    {
        $descriptor = new \PAGI\DialDescriptor\DAHDIDialDescriptor('666', '1');
        $this->assertEquals($descriptor->getChannelDescriptor(), 'DAHDI/G1/666');
        $descriptor = new \PAGI\DialDescriptor\DAHDIDialDescriptor('666', '1', true, false);
        $this->assertEquals($descriptor->getChannelDescriptor(), 'DAHDI/g1/666');
        $this->assertEquals($descriptor->getTechnology(), 'DAHDI');
        $descriptor->setGroup(4);
        $descriptor->setTarget('777');
        $this->assertEquals($descriptor->getChannelDescriptor(), 'DAHDI/g4/777');
        $descriptor->setChannel('1-1');
        $this->assertEquals($descriptor->getChannelDescriptor(), 'DAHDI/1-1/777');
    }
    /**
     * @test
     */
    public function can_use_local_descriptor()
    {
        $descriptor = new \PAGI\DialDescriptor\LocalDialDescriptor('test', '3000');

        $this->assertEquals($descriptor->getChannelDescriptor(), 'LOCAL/3000@test');
        $this->assertEquals($descriptor->getTechnology(), 'LOCAL');

        $descriptor->setTarget('777');
        $this->assertEquals($descriptor->getChannelDescriptor(), 'LOCAL/777');
    }
}
}