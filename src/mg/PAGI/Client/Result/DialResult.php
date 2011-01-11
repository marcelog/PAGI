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
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
namespace PAGI\Client\Result;

use PAGI\Exception\ChannelDownException;

/**
 * This decorated result adds the functionality to check for a dial result.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Result
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
class DialResult extends ExecResult
{
    /**
     * Dialed peer number.
     * @var string
     */
    private $_dialedPeerNumber;

    /**
     * Dialed peer name.
     * @var string
     */
    private $_dialedPeerName;

    /**
     * Total call length in seconds.
     * @var integer
     */
    private $_dialedTime;

    /**
     * Total answered length in seconds.
     * @var integer
     */
    private $_answeredTime;

    /**
     * Dial status.
     * @var string
     */
    private $_dialStatus;

    /**
     * Features available for the call.
     * @var string
     */
    private $_dynamicFeatures;

    /**
     * Returns Peer number.
     *
     * @return string
     */
    public function getPeerNumber()
    {
        return $this->_dialedPeerNumber;
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
        $this->_dialedPeerNumber = $number;
    }

    /**
     * Returns Peer name.
     *
     * @return string
     */
    public function getPeerName()
    {
        return $this->_dialedPeerName;
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
        $this->_dialedPeerName = $name;
    }

    /**
     * Returns total time for the call in seconds.
     *
     * @return integer
     */
    public function getDialedTime()
    {
        $this->_dialedTime;
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
        $this->_dialedTime = $time;
    }

    /**
     * Returns answered time.
     *
     * @return integer
     */
    public function getAnsweredTime()
    {
        return $this->_answeredTime;
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
        $this->_answeredTime = $time;
    }

    /**
     * Returns dial status.
     *
     * @return string
     */
    public function getDialStatus()
    {
        return $this->_dialStatus;
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
        $this->_dialStatus = $status;
    }

    /**
     * Returns features available for the call.
     *
     * @return string
     */
    public function getDynamicFeatures()
    {
        return $this->_dynamicFeatures;
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
        $this->_dynamicFeatures = $features;
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
        if ($result->isResult(-2)) {
            throw new ExecuteCommandException('Failed to execute');
        }
    }
}