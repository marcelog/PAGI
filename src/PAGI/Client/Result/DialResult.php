<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Client\Result;

/**
 * This decorated result adds the functionality to check for a dial result.
 */
class DialResult extends ExecResult
{
    /**
     * Dialed peer number.
     *
     * @var string
     */
    private $dialedPeerNumber;

    /**
     * Dialed peer name.
     *
     * @var string
     */
    private $dialedPeerName;

    /**
     * Total call length in seconds.
     *
     * @var integer
     */
    private $dialedTime;

    /**
     * Total answered length in seconds.
     *
     * @var integer
     */
    private $answeredTime;

    /**
     * Dial status.
     *
     * @var string
     */
    private $dialStatus;

    /**
     * Features available for the call.
     *
     * @var string
     */
    private $dynamicFeatures;

    /**
     * Constructor.
     *
     * @param ResultInterface $result Result to decorate
     */
    public function __construct(ResultInterface $result)
    {
        parent::__construct($result);
    }

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
     * @param string $number Peer number
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
     * @param string $name Peer name
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
     * @param integer $time Dialed time
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
     * @param integer $time Answered time
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
     * @return Boolean
     */
    public function isBusy()
    {
        return $this->dialStatus == 'BUSY';
    }

    /**
     * Returns true if the result was CONGESTION.
     *
     * @return Boolean
     */
    public function isCongestion()
    {
        return $this->dialStatus == 'CONGESTION';
    }

    /**
     * Returns true if the result was CANCEL.
     *
     * @return Boolean
     */
    public function isCancel()
    {
        return $this->dialStatus == 'CANCEL';
    }

    /**
     * Returns true if the result was ANSWER.
     *
     * @return Boolean
     */
    public function isAnswer()
    {
        return $this->dialStatus == 'ANSWER';
    }

    /**
     * Returns true if the result was NOANSWER.
     *
     * @return Boolean
     */
    public function isNoAnswer()
    {
        return $this->dialStatus == 'NOANSWER';
    }

    /**
     * Returns true if the result was CHANUNAVAIL.
     *
     * @return Boolean
     */
    public function isChanUnavailable()
    {
        return $this->dialStatus == 'CHANUNAVAIL';
    }

    /**
     * Set dial status.
     *
     * @param string $status Dial status
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
     * @param string $features Features
     */
    public function setDynamicFeatures($features)
    {
        $this->dynamicFeatures = $features;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('[ Dial: PeerName: %s PeerNumber: %s DialedTime: %d AnsweredTime: %d DialStatus: %s Features: %s ]',
            $this->getPeerName(),
            $this->getPeerNumber(),
            $this->getDialedTime(),
            $this->getAnsweredTime(),
            $this->getDialStatus(),
            $this->getDynamicFeatures()
        );
    }
}
