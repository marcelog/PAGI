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

use PAGI\Exception\RecordException;

/**
 * A record result.
 */
class RecordResult extends ResultDecorator
{
    /**
     * Was the record interrupted because of a hangup?
     *
     * @var Boolean
     */
    private $hangup;

    /**
     * Was the record interrupted because of a dtmf?
     *
     * @var Boolean
     */
    private $dtmf;

    /**
     * Error because of "waitfor"?
     *
     * @var Boolean
     */
    private $waitfor;

    /**
     * Error creating/writing/accessing the file?
     *
     * @var Boolean
     */
    private $writefile;

    /**
     * Was this record a failure?
     *
     * @var Boolean
     */
    private $failed;

    /**
     * Ending position for the recording.
     *
     * @var integer
     */
    private $endpos;

    /**
     * Digit pressed (if any).
     *
     * @var string
     */
    private $digits;

    /**
     * Constructor.
     *
     * @param ResultInterface $result Result to decorate
     */
    public function __construct(ResultInterface $result)
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

    /**
     * Returns true if this recording was interrupted by either a hangup or a
     * dtmf press.
     *
     * @return Boolean
     */
    public function isInterrupted()
    {
        return $this->hangup || $this->dtmf;
    }

    /**
     * Did the user hangup the call?
     *
     * @return Boolean
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
}
