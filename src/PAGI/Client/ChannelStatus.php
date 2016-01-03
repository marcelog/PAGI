<?php
/**
 * ChannelStatus 'Helper'. See: http://www.voip-info.org/wiki/view/channel+status
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/PAGI/
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
namespace PAGI\Client;

/**
 * ChannelStatus 'Helper'. See: http://www.voip-info.org/wiki/view/channel+status
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
class ChannelStatus
{
    /**
     * Down and Available.
     * @var integer
     */
    const DOWN_AVAILABLE = 0;

    /**
     * Channel is down, but reserved.
     * @var integer
     */
    const DOWN_RESERVED = 1;

    /**
     * Channel is off hook.
     * @var integer
     */
    const OFF_HOOK = 2;

    /**
     * Digits (or equivalent) have been dialed.
     * @var integer
     */
    const DIGITS_DIALED = 3;

    /**
     * Line is ringing.
     * @var integer
     */
    const LINE_RINGING = 4;

    /**
     * Remote end is ringing.
     * @var integer
     */
    const REMOTE_RINGING = 5;

    /**
     * Channel is up and running (normal operation).
     * @var integer
     */
    const LINE_UP = 6;

    /**
     * Line is busy.
     * @var integer
     */
    const LINE_BUSY = 7;

    /**
     * This will return the human readable description for the given channel
     * status. See class constants. (False if the status is invalid).
     *
     * @param integer $status Channel status.
     *
     * @return string
     */
    public static function toString($status)
    {
        switch($status)
        {
            case self::DOWN_AVAILABLE:
                return 'Channel is down and available';
            case self::DOWN_RESERVED:
                return 'Channel is down, but reserved';
            case self::OFF_HOOK:
                return 'Channel is off hook';
            case self::DIGITS_DIALED:
                return 'Digits (or equivalent) have been dialed';
            case self::LINE_RINGING:
                return 'Line is ringing';
            case self::REMOTE_RINGING:
                return 'Remote end is ringing';
            case self::LINE_UP:
                return 'Line is up';
            case self::LINE_BUSY:
                return 'Line is busy';
            default:
                return false;
        }
    }
}