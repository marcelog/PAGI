<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\CDR;

use PAGI\Client\ClientInterface;

/**
 * CDR Facade.
 * If the channel has a cdr, that cdr record has it's own set of variables which
 * can be accessed just like channel variables. The following builtin variables
 * are available and, unless specified, read-only.
 *
 * ${CDR(clid)}        Caller ID
 * ${CDR(src)}         Source
 * ${CDR(dst)}         Destination
 * ${CDR(dcontext)}    Destination context
 * ${CDR(channel)}     Channel name
 * ${CDR(dstchannel)}  Destination channel
 * ${CDR(lastapp)}     Last app executed
 * ${CDR(lastdata)}    Last app's arguments
 * ${CDR(start)}       Time the call started.
 * ${CDR(answer)}      Time the call was answered.
 * ${CDR(end)}         Time the call ended.
 * ${CDR(duration)}    Duration of the call.
 * ${CDR(billsec)}     Duration of the call once it was answered.
 * ${CDR(disposition)} ANSWERED, NO ANSWER, BUSY
 * ${CDR(amaflags)}    DOCUMENTATION, BILL, IGNORE etc
 * ${CDR(accountcode)} The channel's account code (read-write).
 * ${CDR(uniqueid)}    The channel's unique id.
 * ${CDR(userfield)}   The channels uses specified field (read-write).
 *
 * In addition, you can set your own extra variables with a traditional
 * Set(CDR(var)=val) to anything you want.
 *
 * NOTE Some CDR values (eg: duration & billsec) can't be accessed until the call
 * has terminated. As of 91617, those values will be calculated on-demand if
 * requested. Until that makes it into a stable release, you can set
 * endbeforehexten=yes in cdr.conf, and then use the "hangup" context to wrap
 * up your call.
 */
class CDRFacade implements CDRInterface
{
    /**
     * AGI Client, needed to access cdr data.
     *
     * @var ClientInterface
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    public function setUserfield($value)
    {
        $this->setCustom('userfield', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserfield()
    {
        return $this->getCustom('userfield');
    }

    /**
     * {@inheritdoc}
     */
    public function getUniqueId()
    {
        return $this->getCustom('uniqueid');
    }

    /**
     * {@inheritdoc}
     */
    public function setAccountCode($value)
    {
        $this->setCustom('accountcode', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getAccountCode()
    {
        return $this->getCustom('accountcode');
    }

    /**
     * {@inheritdoc}
     */
    public function getAMAFlags()
    {
        return $this->getCustom('amaflags');
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->getCustom('disposition');
    }

    /**
     * {@inheritdoc}
     */
    public function getAnswerLength()
    {
        return $this->getCustom('billsec');
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalLength()
    {
        return $this->getCustom('duration');
    }

    /**
     * {@inheritdoc}
     */
    public function getEndTime()
    {
        return $this->getCustom('end');
    }

    /**
     * {@inheritdoc}
     */
    public function getAnswerTime()
    {
        return $this->getCustom('answer');
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTime()
    {
        return $this->getCustom('start');
    }

    /**
     * {@inheritdoc}
     */
    public function getLastAppData()
    {
        return $this->getCustom('lastdata');
    }

    /**
     * {@inheritdoc}
     */
    public function getLastApp()
    {
        return $this->getCustom('lastapp');
    }

    /**
     * {@inheritdoc}
     */
    public function getChannel()
    {
        return $this->getCustom('channel');
    }

    /**
     * {@inheritdoc}
     */
    public function getDestinationChannel()
    {
        return $this->getCustom('dstchannel');
    }

    /**
     * {@inheritdoc}
     */
    public function getCallerId()
    {
        return $this->getCustom('clid');
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->getCustom('src');
    }

    /**
     * {@inheritdoc}
     */
    public function getDestination()
    {
        return $this->getCustom('dst');
    }

    /**
     * {@inheritdoc}
     */
    public function getDestinationContext()
    {
        return $this->getCustom('dcontext');
    }

    /**
     * {@inheritdoc}
     */
    public function getCustom($name)
    {
        return $this->getCDRVariable($name);
    }

    /**
     * {@inheritdoc}
     */
    public function setCustom($name, $value)
    {
        return $this->setCDRVariable($name, $value);
    }

    /**
     * Access agi client to get the variables.
     *
     * @param string $name Variable name
     *
     * @return string
     */
    protected function getCDRVariable($name)
    {
        return $this->client->getFullVariable(sprint('CDR(%s)', $name));
    }

    /**
     * Access agi client to set the variable.
     *
     * @param string $name  Variable name
     * @param string $value Value
     */
    protected function setCDRVariable($name, $value)
    {
        $this->client->setVariable(sprint('CDR(%s)', $name), $value);
    }

    /**
     * Constructor.
     *
     * @param ClientInterface $client AGI Client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
}
