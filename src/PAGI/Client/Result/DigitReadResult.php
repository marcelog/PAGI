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

use PAGI\Exception\ChannelDownException;

/**
 * This decorated result adds the functionality to check for user input. We
 * need a distinction between a single digit read (this class) and a data read
 * (DataReadResult) because asterisk sends the ascii number for the character
 * read (the first case) and the literal string in the latter.
 */
class DigitReadResult extends ResultDecorator implements ReadResultInterface
{
    /**
     * Digits read (if any).
     *
     * @var string
     */
    protected $digits;

    /**
     * Timeout?
     *
     * @var Boolean
     */
    protected $timeout;

    /**
     * Constructor.
     *
     * @param ResultInterface $result Result to decorate
     */
    public function __construct(ResultInterface $result)
    {
        parent::__construct($result);

        $this->digits = false;
        $this->timeout = false;

        $result = $result->getResult();

        switch ($result) {
            case -1:
                throw new ChannelDownException();
                break;

            case 0:
                $this->timeout = true;
                break;

            default:
                $this->digits = chr(intval($result));
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isTimeout()
    {
        return $this->timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function getDigits()
    {
        return $this->digits;
    }

    /**
     * {@inheritdoc}
     */
    public function getDigitsCount()
    {
        return strlen($this->digits);
    }
}
