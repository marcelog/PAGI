<?php
/**
 * This decorated result adds the functionality to check for a dial result.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Result
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/PAGI/
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
namespace PAGI\Client\Result;

use PAGI\Exception\ChannelDownException;
use PAGI\Exception\ExecuteCommandException;

/**
 * This decorated result adds the functionality to check for a dial result.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Result
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class DialResult extends ExecResult
{
    /**
     * Dialed peer number.
     * @var string
     */
    private $dialedPeerNumber;

    /**
     * Dialed peer name.
     * @var string
     */
    private $dialedPeerName;

    /**
     * Total call length in seconds.
     * @var integer
     */
    private $dialedTime;

    /**
     * Total answered length in seconds.
     * @var integer
     */
    private $answeredTime;

    /**
     * Dial status.
     * @var string
     */
    private $dialStatus;

    /**
     * Features available for the call.
     * @var string
     */
    private $dynamicFeatures;

    /**
     * Returns Peer number.
     *
     * @return string
     */
    public function getPeerNumber()
    {
        return $this->dialedPeerNumber;
    }

    /**
     * Set peer number.
     *
     * @param string $number Peer number.
     *
     * @return void
     */
    public function setPeerNumber($number)
    {
        $this->dialedPeerNumber = $number;
    }

    /**
     * Returns Peer name.
     *
     * @return string
     */
    public function getPeerName()
    {
        return $this->dialedPeerName;
    }

    /**
     * Set peer name.
     *
     * @param string $name Peer name.
     *
     * @return void
     */
    public function setPeerName($name)
    {
        $this->dialedPeerName = $name;
    }

    /**
     * Returns total time for the call in seconds.
     *
     * @return integer
     */
    public function getDialedTime()
    {
        return $this->dialedTime;
    }

    /**
     * Set dialed time.
     *
     * @param integer $time Dialed time.
     *
     * @return void
     */
    public function setDialedTime($time)
    {
        $this->dialedTime = $time;
    }

    /**
     * Returns answered time.
     *
     * @return integer
     */
    public function getAnsweredTime()
    {
        return $this->answeredTime;
    }

    /**
     * Set answered time.
     *
     * @param integer $time Answered time.
     *
     * @return void
     */
    public function setAnsweredTime($time)
    {
        $this->answeredTime = $time;
    }

    /**
     * Returns dial status.
     *
     * @return string
     */
    public function getDialStatus()
    {
        return $this->dialStatus;
    }

    /**
     * Returns true if the result was BUSY.
     *
     * @return boolean
     */
    public function isBusy()
    {
        return $this->dialStatus == 'BUSY';
    }

    /**
     * Returns true if the result was CONGESTION.
     *
     * @return boolean
     */
    public function isCongestion()
    {
        return $this->dialStatus == 'CONGESTION';
    }

    /**
     * Returns true if the result was CANCEL.
     *
     * @return boolean
     */
    public function isCancel()
    {
        return $this->dialStatus == 'CANCEL';
    }
    /**
     * Returns true if the result was ANSWER.
     *
     * @return boolean
     */
    public function isAnswer()
    {
        return $this->dialStatus == 'ANSWER';
    }

    /**
     * Returns true if the result was NOANSWER.
     *
     * @return boolean
     */
    public function isNoAnswer()
    {
        return $this->dialStatus == 'NOANSWER';
    }

    /**
     * Returns true if the result was CHANUNAVAIL.
     *
     * @return boolean
     */
    public function isChanUnavailable()
    {
        return $this->dialStatus == 'CHANUNAVAIL';
    }
    /**
     * Set dial status.
     *
     * @param string $status Dial status.
     *
     * @return void
     */
    public function setDialStatus($status)
    {
        $this->dialStatus = $status;
    }

    /**
     * Returns features available for the call.
     *
     * @return string
     */
    public function getDynamicFeatures()
    {
        return $this->dynamicFeatures;
    }

    /**
     * Set features.
     *
     * @param string $features Features.
     *
     * @return void
     */
    public function setDynamicFeatures($features)
    {
        $this->dynamicFeatures = $features;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.ResultDecorator::__toString()
     */
    public function __toString()
    {
        return
            '[ Dial: '
            . ' PeerName: ' . $this->getPeerName()
            . ' PeerNumber: ' . $this->getPeerNumber()
            . ' DialedTime: ' . $this->getDialedTime()
            . ' AnsweredTime: ' . $this->getAnsweredTime()
            . ' DialStatus: ' . $this->getDialStatus()
            . ' Features: ' . $this->getDynamicFeatures()
            . ' ]'
            ;
    }

    /**
     * Constructor.
     *
     * @param IResult $result Result to decorate.
     *
     * @return void
     */
    public function __construct(IResult $result)
    {
        parent::__construct($result);
    }
}
