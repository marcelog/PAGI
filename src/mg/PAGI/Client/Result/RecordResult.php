<?php
/**
 * A record result.
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

use PAGI\Exception\RecordException;

/**
 * A record result.
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
class RecordResult extends ResultDecorator
{
    /**
     * Was the record interrupted because of a hangup?
     * @var boolean
     */
    private $_hangup;

    /**
     * Was the record interrupted because of a dtmf?
     * @var boolean
     */
    private $_dtmf;

    /**
     * Error because of "waitfor"?
     * @var boolean
     */
    private $_waitfor;

    /**
     * Error creating/writing/accessing the file?
     * @var boolean
     */
    private $_writefile;

    /**
     * Was this record a failure?
     * @var boolean
     */
    private $_failed;

    /**
     * Ending position for the recording.
     * @var integer
     */
    private $_endpos;

    /**
     * Digit pressed (if any).
     * @var string
     */
    private $_digits;

    /**
     * Use this to find out if this record was successfull or not. A record is
     * failed only when an error writefile or waitfor is present.
     *
     * @return boolean
     */
    public function isFailed()
    {
        return $this->_waitfor || $this->_writefile;
    }

    /**
     * Returns true if this recording was interrupted by either a hangup or a
     * dtmf press.
     *
     * @return boolean
     */
    public function isInterrupted()
    {
        return $this->_hangup || $this->_dtmf;
    }

    /**
     * Did the user hangup the call?
     *
     * @return boolean
     */
    public function isHangup()
    {
        return $this->_hangup;
    }

    /**
     * Is writefile error present?
     *
     * @return boolean
     */
    public function isWriteFile()
    {
        return $this->_writefile;
    }

    /**
     * Is waitfor error present?
     *
     * @return boolean
     */
    public function isWaitFor()
    {
        return $this->_waitfor;
    }

    /**
     * Returns ending position for this recording.
     *
     * @return integer
     */
    public function getEndPos()
    {
        return $this->_endpos;
    }

    /**
     * Returns the digit pressed to stop this recording (false if none).
     *
     * @return string
     */
    public function getDigits()
    {
        return chr($this->getResult());
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
        $data = $result->getData();
        $this->_endpos = 0;
        $this->_hangup = (strpos($data, 'hangup') !== false);
        $this->_waitfor = (strpos($data, 'waitfor') !== false);
        $this->_writefile = (strpos($data, 'writefile') !== false);
        $this->_dtmf = (strpos($data, 'dtmf') !== false);
        if ($this->_dtmf) {
            $this->_digits = chr($result->getResult());
        }
        if ($this->_writefile || $this->_waitfor) {
            throw new RecordException($data);
        }
        $data = explode('=', $data);
        if (isset($data[1])) {
            $this->_endpos = $data[1];
        }
    }
}