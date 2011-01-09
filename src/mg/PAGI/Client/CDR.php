<?php
/**
 * CDR Facade.
 * If the channel has a cdr, that cdr record has it's own set of variables which
 * can be accessed just like channel variables. The following builtin variables
 * are available and, unless specified, read-only.
 *
 * ${CDR(clid)}	 Caller ID
 * ${CDR(src)}	 Source
 * ${CDR(dst)}	 Destination
 * ${CDR(dcontext)}	 Destination context
 * ${CDR(channel)}	 Channel name
 * ${CDR(dstchannel)}	 Destination channel
 * ${CDR(lastapp)}	 Last app executed
 * ${CDR(lastdata)}	 Last app's arguments
 * ${CDR(start)}	 Time the call started.
 * ${CDR(answer)}	 Time the call was answered.
 * ${CDR(end)}	 Time the call ended.
 * ${CDR(duration)}	 Duration of the call.
 * ${CDR(billsec)}	 Duration of the call once it was answered.
 * ${CDR(disposition)}	 ANSWERED, NO ANSWER, BUSY
 * ${CDR(amaflags)}	 DOCUMENTATION, BILL, IGNORE etc
 * ${CDR(accountcode)}	 The channel's account code (read-write).
 * ${CDR(uniqueid)}	 The channel's unique id.
 * ${CDR(userfield)}	 The channels uses specified field (read-write).
 *
 *
 * In addition, you can set your own extra variables with a traditional
 * Set(CDR(var)=val) to anything you want.
 *
 * NOTE Some CDR values (eg: duration & billsec) can't be accessed until the call
 * has terminated. As of 91617, those values will be calculated on-demand if
 * requested. Until that makes it into a stable release, you can set
 * endbeforehexten=yes in cdr.conf, and then use the "hangup" context to wrap
 * up your call.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\Client;
/**
 * CDR Facade.
 * If the channel has a cdr, that cdr record has it's own set of variables which
 * can be accessed just like channel variables. The following builtin variables
 * are available and, unless specified, read-only.
 *
 * ${CDR(clid)}	 Caller ID
 * ${CDR(src)}	 Source
 * ${CDR(dst)}	 Destination
 * ${CDR(dcontext)}	 Destination context
 * ${CDR(channel)}	 Channel name
 * ${CDR(dstchannel)}	 Destination channel
 * ${CDR(lastapp)}	 Last app executed
 * ${CDR(lastdata)}	 Last app's arguments
 * ${CDR(start)}	 Time the call started.
 * ${CDR(answer)}	 Time the call was answered.
 * ${CDR(end)}	 Time the call ended.
 * ${CDR(duration)}	 Duration of the call.
 * ${CDR(billsec)}	 Duration of the call once it was answered.
 * ${CDR(disposition)}	 ANSWERED, NO ANSWER, BUSY
 * ${CDR(amaflags)}	 DOCUMENTATION, BILL, IGNORE etc
 * ${CDR(accountcode)}	 The channel's account code (read-write).
 * ${CDR(uniqueid)}	 The channel's unique id.
 * ${CDR(userfield)}	 The channels uses specified field (read-write).
 *
 *
 * In addition, you can set your own extra variables with a traditional
 * Set(CDR(var)=val) to anything you want.
 *
 * NOTE Some CDR values (eg: duration & billsec) can't be accessed until the call
 * has terminated. As of 91617, those values will be calculated on-demand if
 * requested. Until that makes it into a stable release, you can set
 * endbeforehexten=yes in cdr.conf, and then use the "hangup" context to wrap
 * up your call.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
class CDR
{
    /**
     * AGI Client, needed to access cdr data.
     * @var IClient
     */
    private $_client;

    /**
     * Set userfileds for cdr. CDR(userfield).
     *
     * @param string $value New userfields to use.
     *
     * @return void
     */
    public function setUserfield($value)
    {
        $this->setCustom('userfield', $value);
    }

    /**
     * The channels uses specified field (read-write). CDR(userfield).
     *
     * @return string
     */
    public function getUserfield()
    {
        return $this->getCustom('userfield');
    }

    /**
     * The channel uniqueid. CDR(uniqueid).
     *
     * @return string
     */
    public function getUniqueId()
    {
        return $this->getCustom('uniqueid');
    }

    /**
     * Sets account code. CDR(accountcode).
     *
     * @param string $value New account code.
     *
     * @return void
     */
    public function setAccountCode($value)
    {
        $this->setCustom('accountcode', $value);
    }

    /**
     * The channel account code. CDR(accountcode).
     *
     * @return string
     */
    public function getAccountCode()
    {
        return $this->getCustom('accountcode');
    }

    /**
     * DOCUMENTATION, BILL, IGNORE etc. CDR(amaflags).
     *
     * @return string
     */
    public function getAMAFlags()
    {
        return $this->getCustom('amaflags');
    }

    /**
     * ANSWERED, NO ANSWER, BUSY, etc. CDR(disposition).
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getCustom('disposition');
    }

    /**
     * Total length for answered part of the call. CDR(billsec).
     *
     * @return string
     */
    public function getAnswerLength()
    {
        return $this->getCustom('billsec');
    }

    /**
     * Total length for the call. CDR(duration).
     *
     * @return string
     */
    public function getTotalLength()
    {
        return $this->getCustom('duration');
    }

    /**
     * Unix timestamp for the time when the call ended. CDR(end).
     *
     * @return integer
     */
    public function getEndTime()
    {
        return $this->getCustom('end');
    }

    /**
     * Unix timestamp for the time when the call was answered. CDR(answer).
     *
     * @return integer
     */
    public function getAnswerTime()
    {
        return $this->getCustom('answer');
    }

    /**
     * Unix timestamp for the time when the call started. CDR(start).
     *
     * @return integer
     */
    public function getStartTime()
    {
        return $this->getCustom('start');
    }

    /**
     * Last application data. CDR(lastdata).
     *
     * @return string
     */
    public function getLastAppData()
    {
        return $this->getCustom('lastdata');
    }

    /**
     * Last application run. CDR(lastapp).
     *
     * @return string
     */
    public function getLastApp()
    {
        return $this->getCustom('lastapp');
    }

    /**
     * Returns channel name. CDR(channel).
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->getCustom('channel');
    }

    /**
     * Returns destination channel for this call. CDR(dstchannel)
     *
     * @return string
     */
    public function getDestinationChannel()
    {
        return $this->getCustom('dstchannel');
    }

    /**
     * Returns caller id for this call. CDR(clid)
     *
     * @return string
     */
    public function getCallerId()
    {
        return $this->getCustom('clid');
    }

    /**
     * Returns source for this call. CDR(src)
     *
     * @return string
     */
    public function getSource()
    {
        return $this->getCustom('src');
    }

    /**
     * Returns destination for this call. CDR(dst)
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->getCustom('dst');
    }

    /**
     * Returns destination context for this call. CDR(dcontext)
     *
     * @return string
     */
    public function getDestinationContext()
    {
        return $this->getCustom('dcontext');
    }

    /**
     * Returns the custom CDR variable.
     *
     * @param string $name CDR Variable.
     *
     * @return string
     */
    public function getCustom($name)
    {
        return $this->getCDRVariable($name);
    }

    /**
     * Sets a custom cdr variable.
     *
     * @param string $name  CDR variable.
     * @param string $value Value.
     *
     * @return void
     */
    public function setCustom($name, $value)
    {
        return $this->setCDRVariable($name, $value);
    }

    /**
     * Access AGI client to get the variables.
     *
     * @param string $name Variable name.
     *
     * @return string
     */
    protected function getCDRVariable($name)
    {
        return $this->_client->getFullVariable('CDR(' . $name . ')');
    }

    /**
     * Access AGI client to set the variable.
     *
     * @param string $name  Variable name.
     * @param string $value Value.
     *
     * @return void
     */
    protected function setCDRVariable($name, $value)
    {
        $this->_client->setVariable('CDR(' . $name . ')', $value);
    }

    /**
     * Constructor.
     *
     * @param IClient $client AGI Client.
     *
     * @return void
     */
    public function __construct(IClient $client)
    {
        $this->_client = $client;
    }
}