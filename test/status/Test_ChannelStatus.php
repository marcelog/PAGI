<?php
/**
 * This class will test the channel status helper.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Status
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
use PAGI\Client\ChannelStatus;

/**
 * This class will test the channel status helper.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Status
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_ChannelStatus extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();
    /**
     * @test
     */
    public function can_correct_status()
    {
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::DOWN_AVAILABLE), 'Channel is down and available');
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::DOWN_RESERVED), 'Channel is down, but reserved');
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::OFF_HOOK), 'Channel is off hook');
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::DIGITS_DIALED), 'Digits (or equivalent) have been dialed');
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::LINE_RINGING), 'Line is ringing');
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::REMOTE_RINGING), 'Remote end is ringing');
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::LINE_UP), 'Line is up');
        $this->assertEquals(ChannelStatus::toString(ChannelStatus::LINE_BUSY), 'Line is busy');
        $this->assertFalse(ChannelStatus::toString(123123));
    }
}
}