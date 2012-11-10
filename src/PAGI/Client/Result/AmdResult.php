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

/**
 * This decorated result adds the functionality to check for an AMD result.
 */
class AmdResult extends ExecResult
{
    /**
     * Cause
     *
     * @var string 'MACHINE'|'HUMAN'|'NOTSURE'|'HANGUP'
     */
    private $status;

    /**
     * Cause
     *
     * @var string 'TOOLONG'|'INITIALSILENCE'|'HUMAN'|'LONGGREETING'|'MAXWORDLENGTH'
     */
    private $cause;

    /**
     * Constructor.
     *
     * @param ResultInterface $result Result to decorate
     */
    public function __construct(ResultInterface $result)
    {
        parent::__construct($result);
    }

    /**
     * Returns the cause string.
     *
     * @return string
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Returns the status string.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the cause string
     *
     * @param string $cause
     */
    public function setCause($cause)
    {
        $this->cause = $cause;
    }

    /**
     * Sets the cause string
     *
     * @param string $cause
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * True if the status equals the given string
     *
     * @param string $string
     *
     * @return Boolean
     */
    private function isStatus($string)
    {
        return strcasecmp($this->status, $string) === 0;
    }

    /**
     * True if the cause equals the given string
     *
     * @param string $string
     *
     * @return Boolean
     */
    private function isCause($string)
    {
        return strncasecmp($this->cause, $string, strlen($string)) === 0;
    }

    /**
     * True if AMD detected an answering machine.
     *
     * @return Boolean
     */
    public function isMachine()
    {
        return $this->isStatus('MACHINE');
    }

    /**
     * True if AMD detected a hangup.
     *
     * @return Boolean
     */
    public function isHangup()
    {
        return $this->isStatus('HANGUP');
    }

    /**
     * True if AMD detected a human.
     *
     * @return Boolean
     */
    public function isHuman()
    {
        return $this->isStatus('HUMAN');
    }

    /**
     * True if AMD failed detecting an answering machine or human.
     *
     * @return Boolean
     */
    public function isNotSure()
    {
        return $this->isStatus('NOTSURE');
    }

    /**
     * True if AMD status is due to a timeout when detecting.
     *
     * @return Boolean
     */
    public function isCauseTooLong()
    {
        return $this->isCause('TOOLONG');
    }

    /**
     * True if AMD status is due to a silence duration.
     *
     * @return Boolean
     */
    public function isCauseInitialSilence()
    {
        return $this->isCause('INITIALSILENCE');
    }

    /**
     * True if AMD status is due to a silence after a greeting.
     *
     * @return Boolean
     */
    public function isCauseHuman()
    {
        return $this->isCause('HUMAN');
    }

    /**
     * True if AMD status is due to a long greeting detected.
     *
     * @return Boolean
     */
    public function isCauseGreeting()
    {
        return $this->isCause('LONGGREETING');
    }

    /**
     * True if AMD status is due to a maximum number of words reached.
     *
     * @return Boolean
     */
    public function isCauseWordLength()
    {
        return $this->isCause('MAXWORDLENGTH');
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprint('[ Amd: Status: %s Cause: %s ]', $this->status, $this->cause);
    }
}
