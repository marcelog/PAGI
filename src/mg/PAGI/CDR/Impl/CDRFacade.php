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
 * @category   Pagi
 * @package    CDR
 * @subpackage Impl
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
namespace PAGI\CDR\Impl;

use PAGI\Client\IClient;
use PAGI\CDR\ICDR;

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
 * @category   Pagi
 * @package    CDR
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class CDRFacade implements ICDR
{
    /**
     * AGI Client, needed to access cdr data.
     * @var IClient
     */
    private $_client;

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::setUserfield()
     */
    public function setUserfield($value)
    {
        $this->setCustom('userfield', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getUserfield()
     */
    public function getUserfield()
    {
        return $this->getCustom('userfield');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getUniqueId()
     */
    public function getUniqueId()
    {
        return $this->getCustom('uniqueid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::setAccountCode()
     */
    public function setAccountCode($value)
    {
        $this->setCustom('accountcode', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getAccountCode()
     */
    public function getAccountCode()
    {
        return $this->getCustom('accountcode');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getAMAFlags()
     */
    public function getAMAFlags()
    {
        return $this->getCustom('amaflags');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getStatus()
     */
    public function getStatus()
    {
        return $this->getCustom('disposition');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getAnswerLength()
     */
    public function getAnswerLength()
    {
        return $this->getCustom('billsec');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getTotalLength()
     */
    public function getTotalLength()
    {
        return $this->getCustom('duration');
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getEndTime()
     */
    public function getEndTime()
    {
        return $this->getCustom('end');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getAnswerTime()
     */
    public function getAnswerTime()
    {
        return $this->getCustom('answer');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getStartTime()
     */
    public function getStartTime()
    {
        return $this->getCustom('start');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getLastAppData()
     */
    public function getLastAppData()
    {
        return $this->getCustom('lastdata');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getLastApp()
     */
    public function getLastApp()
    {
        return $this->getCustom('lastapp');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getChannel()
     */
    public function getChannel()
    {
        return $this->getCustom('channel');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getDestinationChannel()
     */
    public function getDestinationChannel()
    {
        return $this->getCustom('dstchannel');
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getCallerId()
     */
    public function getCallerId()
    {
        return $this->getCustom('clid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getSource()
     */
    public function getSource()
    {
        return $this->getCustom('src');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getDestination()
     */
    public function getDestination()
    {
        return $this->getCustom('dst');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getDestinationContext()
     */
    public function getDestinationContext()
    {
        return $this->getCustom('dcontext');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::getCustom()
     */
    public function getCustom($name)
    {
        return $this->getCDRVariable($name);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CDR.ICDR::setCustom()
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