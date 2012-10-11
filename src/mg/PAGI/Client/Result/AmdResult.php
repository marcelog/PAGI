<?php
/**
 * This decorated result adds the functionality to check for an AMD result.
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
 * Copyright 2012 Marcelo Gornstein <marcelog@gmail.com>
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

/**
 * This decorated result adds the functionality to check for an AMD result.
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
class AmdResult extends ExecResult
{
    /**
     * Cause
     * @var string 'MACHINE'|'HUMAN'|'NOTSURE'|'HANGUP'
     */
    private $_status;

    /**
     * Cause
     * @var string 'TOOLONG'|'INITIALSILENCE'|'HUMAN'|'LONGGREETING'|'MAXWORDLENGTH'
     */
    private $_cause;

    /**
     * Returns the cause string.
     *
     * @return string
     */
    public function getCause()
    {
        return $this->_cause;
    }

    /**
     * Returns the status string.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets the cause string
     *
     * @param string $cause
     *
     * @return void
     */
    public function setCause($cause)
    {
        $this->_cause = $cause;
    }

    /**
     * Sets the cause string
     *
     * @param string $cause
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    /**
     * True if the status equals the given string
     *
     * @param string $string
     *
     * @return boolean
     */
    private function isStatus($string)
    {
        return strcasecmp($this->_status, $string) === 0;
    }

    /**
     * True if the cause equals the given string
     *
     * @param string $string
     *
     * @return boolean
     */
    private function isCause($string)
    {
        return strncasecmp($this->_cause, $string, strlen($string)) === 0;
    }

    /**
     * True if AMD detected an answering machine.
     *
     * @return boolean
     */
    public function isMachine()
    {
        return $this->isStatus('MACHINE');
    }

    /**
     * True if AMD detected a hangup.
     *
     * @return boolean
     */
    public function isHangup()
    {
        return $this->isStatus('HANGUP');
    }

    /**
     * True if AMD detected a human.
     *
     * @return boolean
     */
    public function isHuman()
    {
        return $this->isStatus('HUMAN');
    }

    /**
     * True if AMD failed detecting an answering machine or human.
     *
     * @return boolean
     */
    public function isNotSure()
    {
        return $this->isStatus('NOTSURE');
    }

    /**
     * True if AMD status is due to a timeout when detecting.
     *
     * @return boolean
     */
    public function isCauseTooLong()
    {
        return $this->isCause('TOOLONG');
    }

    /**
     * True if AMD status is due to a silence duration.
     *
     * @return boolean
     */
    public function isCauseInitialSilence()
    {
        return $this->isCause('INITIALSILENCE');
    }

    /**
     * True if AMD status is due to a silence after a greeting.
     *
     * @return boolean
     */
    public function isCauseHuman()
    {
        return $this->isCause('HUMAN');
    }

    /**
     * True if AMD status is due to a long greeting detected.
     *
     * @return boolean
     */
    public function isCauseGreeting()
    {
        return $this->isCause('LONGGREETING');
    }

    /**
     * True if AMD status is due to a maximum number of words reached.
     *
     * @return boolean
     */
    public function isCauseWordLength()
    {
        return $this->isCause('MAXWORDLENGTH');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.ResultDecorator::__toString()
     */
    public function __toString()
    {
        return
            '[ Amd: '
            . ' Status: ' . $this->_status
            . ' Cause: ' . $this->_cause
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