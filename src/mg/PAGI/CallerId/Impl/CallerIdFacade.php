<?php
/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Callerid
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
namespace PAGI\CallerId\Impl;

use PAGI\CallerId\ICallerId;
use PAGI\Client\IClient;

/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Callerid
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
class CallerIdFacade implements ICallerId
{
    /**
     * Instance of client to access caller id variables.
     * @var IClient
     */
    private $_client;

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setANI()
     */
    public function setANI($value)
    {
        $this->setCallerIdVariable('ani', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getANI()
     */
    public function getANI()
    {
        return $this->getCallerIdVariable('ani');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setDNID()
     */
    public function setDNID($value)
    {
        $this->setCallerIdVariable('dnid', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getDNID()
     */
    public function getDNID()
    {
        return $this->getCallerIdVariable('dnid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setRDNIS()
     */
    public function setRDNIS($value)
    {
        $this->setCallerIdVariable('rdnis', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getRDNIS()
     */
    public function getRDNIS()
    {
        return $this->getCallerIdVariable('rdnis');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setName()
     */
    public function setName($value)
    {
        $num = $this->getNumber();
        $this->setCallerIdVariable('name', $value);
        $this->setCallerIdVariable('all', "$value<$num>");
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getName()
     */
    public function getName()
    {
        return $this->getCallerIdVariable('name');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getNumber()
     */
    public function getNumber()
    {
        return $this->getCallerIdVariable('num');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setNumber()
     */
    public function setNumber($value)
    {
        $name = $this->getName();
        $this->setCallerIdVariable('num', $value);
        $this->setCallerIdVariable('all', "$name<$value>");
    }

    /**
     * Access AGI client to get the variables.
     *
     * @param string $name Variable name.
     *
     * @return string
     */
    protected function getCallerIdVariable($name)
    {
        return $this->_client->getFullVariable('CALLERID(' . $name . ')');
    }

    /**
     * Access AGI client to set the variable.
     *
     * @param string $name  Variable name.
     * @param string $value Value.
     *
     * @return void
     */
    protected function setCallerIdVariable($name, $value)
    {
        $this->_client->setVariable('CALLERID(' . $name . ')', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setCallerPres()
     */
    public function setCallerPres($presentationMode)
    {
        $this->_client->exec('SET', array("CALLERPRES()=$presentationMode"));
    }

    /**
     * Standard procedure.
     *
     * @return string
     */
    public function __toString()
    {
        return
            '[ CallerID: '
            . ' number: ' . $this->getNumber()
            . ' name: ' . $this->getName()
            . ' dnid: ' . $this->getDNID()
            . ' rdnis: ' . $this->getRDNIS()
            . ' ani: ' . $this->getANI()
            . ']'
        ;
    }

    /**
     * Constructor.
     *
     * @param IClient $client AGI Client to use.
     *
     * @return void
     */
    public function __construct(IClient $client)
    {
        $this->_client = $client;
    }
}