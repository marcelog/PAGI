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
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class RecordResult extends ResultDecorator
{
    /**
     * Was the record interrupted because of a hangup?
     * @var boolean
     */
    private $hangup;

    /**
     * Was the record interrupted because of a dtmf?
     * @var boolean
     */
    private $dtmf;

    /**
     * Error because of "waitfor"?
     * @var boolean
     */
    private $waitfor;

    /**
     * Error creating/writing/accessing the file?
     * @var boolean
     */
    private $writefile;

    /**
     * Was this record a failure?
     * @var boolean
     */
    private $failed;

    /**
     * Ending position for the recording.
     * @var integer
     */
    private $endpos;

    /**
     * Digit pressed (if any).
     * @var string
     */
    private $digits;

    /**
     * Returns true if this recording was interrupted by either a hangup or a
     * dtmf press.
     *
     * @return boolean
     */
    public function isInterrupted()
    {
        return $this->hangup || $this->dtmf;
    }

    /**
     * Did the user hangup the call?
     *
     * @return boolean
     */
    public function isHangup()
    {
        return $this->hangup;
    }

    /**
     * Returns ending position for this recording.
     *
     * @return integer
     */
    public function getEndPos()
    {
        return $this->endpos;
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
        $this->endpos = 0;
        $this->hangup = (strpos($data, 'hangup') !== false);
        $this->waitfor = (strpos($data, 'waitfor') !== false);
        $this->writefile = (strpos($data, 'writefile') !== false);
        $this->dtmf = (strpos($data, 'dtmf') !== false);
        if ($this->dtmf) {
            $this->digits = chr($result->getResult());
        }
        if ($this->writefile || $this->waitfor) {
            throw new RecordException($data);
        }
        $data = explode('=', $data);
        if (isset($data[1])) {
            $this->endpos = $data[1];
        }
    }
}
