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
    private $_dialedPeerNumber;
    private $_dialedPeerName;
    private $_dialedTime;
    private $_answeredTime;
    private $_dialStatus;
    private $_dynamicFeatures;

    public function getPeerNumber()
    {
        return $this->_dialedPeerNumber;
    }

    public function setPeerNumber($number)
    {
        $this->_dialedPeerNumber = $number;
    }

    public function getPeerName()
    {
        return $this->_dialedPeerName;
    }

    public function setPeerName($name)
    {
        $this->_dialedPeerName = $name;
    }

    public function getDialedTime()
    {
        $this->_dialedTime;
    }

    public function setDialedTime($time)
    {
        $this->_dialedTime = $time;
    }

    public function getAnsweredTime()
    {
        return $this->_answeredTime;
    }

    public function setAnsweredTime($time)
    {
        $this->_answeredTime = $time;
    }

    public function getDialStatus()
    {
        return $this->_dialStatus;
    }

    public function setDialStatus($status)
    {
        $this->_dialStatus = $status;
    }

    public function getDynamicFeatures()
    {
        return $this->_dynamicFeatures;
    }

    public function setDynamicFeatures($features)
    {
        $this->_dynamicFeatures = $features;
    }

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